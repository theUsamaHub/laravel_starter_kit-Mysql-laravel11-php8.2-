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

        if ($from = $request->input('from')) {
            $query->whereDate('subscribed_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('subscribed_at', '<=', $to);
        }

        $subscribers = $query->latest()->paginate(30);

        $subscriberCounts = Subscriber::selectRaw("count(*) as total")
            ->selectRaw("count(case when unsubscribed_at is null then 1 end) as active_count")
            ->selectRaw("count(case when unsubscribed_at is not null then 1 end) as unsubscribed_count")
            ->first();

        $stats = [
            'total' => $subscriberCounts->total,
            'active' => $subscriberCounts->active_count,
            'unsubscribed' => $subscriberCounts->unsubscribed_count,
        ];

        return view('admin.subscribers.index', compact('subscribers', 'stats'));
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return back()->with('success', 'Subscriber deleted.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Subscriber::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->input('filter') === 'unsubscribed') {
            $query->whereNotNull('unsubscribed_at');
        } else {
            $query->active();
        }

        if ($from = $request->input('from')) {
            $query->whereDate('subscribed_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('subscribed_at', '<=', $to);
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers-' . now()->format('Y-m-d-His') . '.csv"',
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Name', 'Subscribed At', 'IP Address']);

            $query->latest()->chunk(200, function ($subscribers) use ($handle) {
                foreach ($subscribers as $subscriber) {
                    fputcsv($handle, [
                        $subscriber->email,
                        $subscriber->name,
                        $subscriber->subscribed_at?->toDateTimeString(),
                        $subscriber->ip_address,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
