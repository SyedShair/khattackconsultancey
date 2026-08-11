<?php

namespace App\Http\Controllers;

use App\Mail\ConsultationBookingConfirmedMail;
use App\Mail\LiveChatWaitingMail;
use App\Mail\NewConsultationBookingAdminMail;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\ConsultationBooking;
use App\Models\User;
use App\Services\AvailabilityService;
use App\Services\GroqClient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AssistantController extends Controller
{
    public function __construct(
        protected AvailabilityService $availability,
        protected GroqClient $groq,
    ) {
    }

    /**
     * Freeform message → Groq AI reply. Used when the visitor types
     * something instead of using the menu buttons.
     */
    public function ai(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['nullable', 'array', 'max:10'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:1000'],
        ]);

        $reply = $this->groq->reply($validated['message'], $validated['history'] ?? []);

        return response()->json(['reply' => $reply]);
    }

    /**
     * Upcoming bookable dates (open/closed per Settings hours).
     */
    public function availableDates()
    {
        return response()->json(['dates' => $this->availability->upcomingDates()]);
    }

    /**
     * Bookable time slots for one specific date.
     */
    public function availableSlots(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        return response()->json(['slots' => $this->availability->slotsForDate($validated['date'])]);
    }

    /**
     * Create the consultation booking. Re-checks the slot is still free
     * right before saving, to guard against double-booking races.
     */
    public function book(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:150'],
            'query' => ['nullable', 'string', 'max:1000'],
            'date'  => ['required', 'date', 'after_or_equal:today'],
            'start' => ['required', 'date_format:H:i'],
        ]);

        if (! $this->availability->isSlotAvailable($validated['date'], $validated['start'])) {
            return response()->json([
                'message' => 'Sorry, that time slot was just taken. Please pick another one.',
            ], 422);
        }

        $end = Carbon::parse($validated['start'])->addMinutes(AvailabilityService::SLOT_MINUTES)->format('H:i');

        $booking = ConsultationBooking::create([
            'name'         => $validated['name'],
            'phone'        => $validated['phone'],
            'email'        => $validated['email'],
            'query'        => $validated['query'] ?? null,
            'booking_date' => $validated['date'],
            'start_time'   => $validated['start'],
            'end_time'     => $end,
            'status'       => 'confirmed',
        ]);

        $this->notifyBookingCreated($booking);

        return response()->json([
            'message' => 'Booking confirmed.',
            'booking' => [
                'date'  => Carbon::parse($booking->booking_date)->format('D, M j, Y'),
                'start' => Carbon::parse($booking->start_time)->format('g:i A'),
                'end'   => Carbon::parse($booking->end_time)->format('g:i A'),
            ],
        ]);
    }

    /**
     * Emails the client their confirmation and alerts every admin.
     * Wrapped so that a mail failure (bad SMTP config, etc.) never
     * breaks the booking itself — the booking is already saved by
     * the time this runs.
     */
    protected function notifyBookingCreated(ConsultationBooking $booking): void
    {
        try {
            Mail::to($booking->email)->send(new ConsultationBookingConfirmedMail($booking));
        } catch (\Throwable $e) {
            Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }

        try {
            $adminEmails = User::role('admin')->pluck('email')->filter();
            if ($adminEmails->isNotEmpty()) {
                Mail::to($adminEmails)->send(new NewConsultationBookingAdminMail($booking));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send booking admin alert email: ' . $e->getMessage());
        }
    }

    /**
     * Start a new "talk to our team" live-chat session, capturing the
     * visitor's basic details and their initial query as the first
     * visitor message in the thread.
     */
    public function startChat(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:150'],
            'query' => ['required', 'string', 'max:1000'],
        ]);

        $session = ChatSession::create([
            'uuid'                    => (string) Str::uuid(),
            'name'                    => $validated['name'],
            'phone'                   => $validated['phone'] ?? null,
            'email'                   => $validated['email'],
            'query'                   => $validated['query'],
            'status'                  => 'open',
            'last_visitor_message_at' => now(),
        ]);

        $session->messages()->create([
            'sender'  => 'visitor',
            'message' => $validated['query'],
        ]);

        $this->notifyLiveChatWaiting($session);

        return response()->json([
            'session_uuid' => $session->uuid,
            'message' => "Thanks {$validated['name']}! Your message has been sent to our team — someone will reply here shortly.",
        ]);
    }

    /**
     * Alerts every admin by email that a visitor is waiting to talk.
     * Wrapped so a mail failure never breaks the chat handoff itself.
     */
    protected function notifyLiveChatWaiting(ChatSession $session): void
    {
        try {
            $adminEmails = User::role('admin')->pluck('email')->filter();
            if ($adminEmails->isNotEmpty()) {
                Mail::to($adminEmails)->send(new LiveChatWaitingMail($session));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send live chat waiting alert email: ' . $e->getMessage());
        }
    }

    /**
     * Visitor sends a follow-up message in an already-open live chat.
     */
    public function sendMessage(Request $request, string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        if ($session->status === 'closed') {
            return response()->json(['message' => 'This chat has been closed.'], 422);
        }

        $session->messages()->create([
            'sender'  => 'visitor',
            'message' => $validated['message'],
        ]);
        $session->update(['last_visitor_message_at' => now()]);

        return response()->json(['message' => 'sent']);
    }

    /**
     * Visitor-side polling: fetch messages newer than a given ID, so the
     * widget can show admin replies without a full page reload.
     */
    public function fetchMessages(Request $request, string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();

        $afterId = (int) $request->get('after_id', 0);

        $messages = $session->messages()
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get(['id', 'sender', 'message', 'created_at']);

        return response()->json([
            'status'              => $session->status,
            'admin_typing'        => $session->is_admin_typing,
            'assigned_admin_name' => $session->assigned_admin_name,
            'messages' => $messages->map(fn ($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender,
                'message'    => $m->message,
                'created_at' => $m->created_at->format('g:i A'),
            ]),
        ]);
    }
}