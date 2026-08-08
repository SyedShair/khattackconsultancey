<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('contact-messages.index');
    }

    /**
     * AJAX: paginated / searchable / filterable list of messages.
     */
    public function data(Request $request)
    {
        $query = ContactMessage::latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $perPage = (int) $request->get('per_page', 10);
        $messages = $query->paginate($perPage)->withQueryString();

        $messages->getCollection()->transform(fn (ContactMessage $m) => [
            'id'         => $m->id,
            'name'       => $m->full_name,
            'email'      => $m->email,
            'phone'      => $m->phone,
            'subject'    => $m->subject ?: '—',
            'status'     => $m->status,
            'created_at' => $m->created_at->format('Y-m-d H:i'),
        ]);

        return response()->json([
            'data'         => $messages->items(),
            'current_page' => $messages->currentPage(),
            'last_page'    => $messages->lastPage(),
            'total'        => $messages->total(),
        ]);
    }

    /**
     * AJAX: single message (for the detail modal). Auto-marks as read
     * the first time it's opened, if it was still "new".
     */
    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read']);
        }

        return response()->json([
            'id'         => $contactMessage->id,
            'name'       => $contactMessage->full_name,
            'email'      => $contactMessage->email,
            'phone'      => $contactMessage->phone,
            'subject'    => $contactMessage->subject,
            'message'    => $contactMessage->message,
            'status'     => $contactMessage->status,
            'created_at' => $contactMessage->created_at->format('Y-m-d H:i'),
        ]);
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(ContactMessage::STATUSES))],
        ]);

        $contactMessage->update($validated);

        return response()->json(['message' => "Marked as \"{$contactMessage->status}\"."]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return response()->json(['message' => 'Message deleted.']);
    }
}