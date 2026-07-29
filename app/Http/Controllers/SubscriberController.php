<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $existing = Subscriber::where('email', $validated['email'])->first();

        if ($existing) {
            if ($existing->unsubscribed_at) {
                $existing->update([
                    'unsubscribed_at' => null,
                    'subscribed_at' => now(),
                ]);
            }

            return back()->with('success', 'You are already subscribed!');
        }

        Subscriber::create([
            'email' => $validated['email'],
            'name' => $validated['name'] ?? null,
            'subscribed_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Thank you for subscribing!');
    }
}
