<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $validated['ip_address'] = $request->ip();
        $contact = Contact::create($validated);

        // Notify all admin users
        $admins = User::whereHas('roles', fn($q) => $q->where('slug', 'admin'))->get();
        foreach ($admins as $admin) {
            $admin->notify(new ContactFormNotification(
                $validated['name'],
                $validated['email'],
                $validated['subject'] ?? 'No Subject',
                $validated['message']
            ));
        }

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
