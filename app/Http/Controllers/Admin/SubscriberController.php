<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $query = Subscriber::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->input('filter') === 'active') {
            $query->active();
        } elseif ($request->input('filter') === 'unsubscribed') {
            $query->whereNotNull('unsubscribed_at');
        }

        $subscribers = $query->latest()->paginate(30);

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return back()->with('success', 'Subscriber deleted.');
    }

    public function export(): StreamedResponse
    {
        $subscribers = Subscriber::active()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers-' . now()->format('Y-m-d-His') . '.csv"',
        ];

        $callback = function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Name', 'Subscribed At', 'IP Address']);

            foreach ($subscribers as $subscriber) {
                fputcsv($handle, [
                    $subscriber->email,
                    $subscriber->name,
                    $subscriber->subscribed_at?->toDateTimeString(),
                    $subscriber->ip_address,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
