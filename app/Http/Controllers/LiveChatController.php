<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use Illuminate\Http\Request;

class LiveChatController extends Controller
{
    public function index()
    {
        return view('live-chat.index');
    }

    /**
     * AJAX: list of sessions, most recently active first.
     */
    public function data(Request $request)
    {
        $query = ChatSession::orderByDesc('last_visitor_message_at');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $sessions = $query->get();

        return response()->json([
            'sessions' => $sessions->map(fn (ChatSession $s) => [
                'uuid'            => $s->uuid,
                'name'            => $s->name ?: 'Anonymous',
                'email'           => $s->email,
                'phone'           => $s->phone,
                'status'          => $s->status,
                'has_unread'      => $s->has_unread,
                'assigned_admin'  => $s->assigned_admin_name,
                'last_active'     => optional($s->last_visitor_message_at)->diffForHumans(),
            ]),
        ]);
    }

    /**
     * AJAX: full thread for one session. Marks it read, and assigns/
     * refreshes the currently-connected admin's name so the visitor's
     * widget can show who they're chatting with.
     */
    public function show(string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();
        $session->update([
            'last_admin_read_at'  => now(),
            'assigned_admin_name' => auth()->user()->name ?? $session->assigned_admin_name,
        ]);

        return response()->json([
            'uuid'    => $session->uuid,
            'name'    => $session->name,
            'email'   => $session->email,
            'phone'   => $session->phone,
            'query'   => $session->query,
            'status'  => $session->status,
            'messages' => $session->messages->map(fn ($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender,
                'message'    => $m->message,
                'created_at' => $m->created_at->format('g:i A'),
            ]),
        ]);
    }

    /**
     * AJAX: poll for new messages since a given ID (for the admin's
     * open chat panel to live-update without reloading).
     */
    public function poll(Request $request, string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();
        $afterId = (int) $request->get('after_id', 0);

        $messages = $session->messages()
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get(['id', 'sender', 'message', 'created_at']);

        if ($messages->isNotEmpty()) {
            $session->update(['last_admin_read_at' => now()]);
        }

        return response()->json([
            'status'   => $session->status,
            'messages' => $messages->map(fn ($m) => [
                'id'         => $m->id,
                'sender'     => $m->sender,
                'message'    => $m->message,
                'created_at' => $m->created_at->format('g:i A'),
            ]),
        ]);
    }

    /**
     * AJAX: admin is actively typing a reply. Called (debounced) from
     * the admin reply box's keystrokes; sets a short-lived "typing until"
     * timestamp the visitor widget polls for, WhatsApp-style.
     */
    public function typing(string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();
        $session->update([
            'admin_typing_until'  => now()->addSeconds(4),
            'assigned_admin_name' => auth()->user()->name ?? $session->assigned_admin_name,
        ]);

        return response()->json(['ok' => true]);
    }

    public function reply(Request $request, string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = $session->messages()->create([
            'sender'  => 'admin',
            'message' => $validated['message'],
        ]);
        $session->update([
            'last_admin_read_at'  => now(),
            'assigned_admin_name' => auth()->user()->name ?? $session->assigned_admin_name,
            'admin_typing_until'  => null, // message sent, stop showing "typing..."
        ]);

        return response()->json([
            'message' => [
                'id'         => $message->id,
                'sender'     => $message->sender,
                'message'    => $message->message,
                'created_at' => $message->created_at->format('g:i A'),
            ],
        ]);
    }

    public function close(string $uuid)
    {
        $session = ChatSession::where('uuid', $uuid)->firstOrFail();
        $session->update(['status' => 'closed']);

        return response()->json(['message' => 'Chat closed.']);
    }

    /**
     * AJAX: lightweight polling endpoint for the sidebar badge + global
     * toast notifications. Returns only OPEN sessions that currently have
     * an unread visitor message, so it stays cheap to poll frequently
     * from every admin page (not just the Live Chat inbox itself).
     */
    public function notifications()
    {
        $unread = ChatSession::where('status', 'open')->get()->filter->has_unread->values();

        return response()->json([
            'unread_count' => $unread->count(),
            'sessions'     => $unread->map(fn (ChatSession $s) => [
                'uuid' => $s->uuid,
                'name' => $s->name ?: 'Anonymous',
            ]),
        ]);
    }
}