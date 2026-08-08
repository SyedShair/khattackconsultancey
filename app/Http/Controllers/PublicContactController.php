<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class PublicContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:150'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'subject'    => ['nullable', 'string', 'max:150'],
            'message'    => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return back()
            ->with('status', "Thanks {$validated['first_name']}, your message has been received. We'll get back to you soon.")
            ->withFragment('tb__contact');
    }
}