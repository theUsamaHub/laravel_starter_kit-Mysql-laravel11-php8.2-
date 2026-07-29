<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::with('user');

        if ($event = $request->input('event')) {
            $query->where('event', $event);
        }

        if ($user_id = $request->input('user_id')) {
            $query->where('user_id', $user_id);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('auditable_type', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $logs = $query->latest()->paginate(30);

        $todayStart = today()->startOfDay();
        $stats = ActivityLog::selectRaw("count(*) as total")
            ->selectRaw("count(case when created_at >= ? then 1 end) as today_count", [$todayStart])
            ->selectRaw("count(case when event = 'created' then 1 end) as created_count")
            ->selectRaw("count(case when event = 'updated' then 1 end) as updated_count")
            ->selectRaw("count(case when event = 'deleted' then 1 end) as deleted_count")
            ->first();

        $stats = [
            'total' => (int) $stats->total,
            'today' => (int) $stats->today_count,
            'events' => array_filter([
                'created' => (int) $stats->created_count,
                'updated' => (int) $stats->updated_count,
                'deleted' => (int) $stats->deleted_count,
            ]),
        ];

        return view('admin.activity-logs.index', compact('logs', 'stats'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = ActivityLog::with('user');

        if ($event = $request->input('event')) {
            $query->where('event', $event);
        }

        if ($user_id = $request->input('user_id')) {
            $query->where('user_id', $user_id);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('auditable_type', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-logs-' . now()->format('Y-m-d-His') . '.csv"',
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Time', 'User', 'Event', 'Model', 'Model ID', 'IP Address', 'User Agent', 'Old Values', 'New Values']);

            $query->latest()->chunk(200, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->created_at->toDateTimeString(),
                        $log->user?->name ?? 'System',
                        $log->event,
                        class_basename($log->auditable_type),
                        $log->auditable_id,
                        $log->ip_address,
                        $log->user_agent,
                        json_encode($log->old_values),
                        json_encode($log->new_values),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        ActivityLog::query()->truncate();

        return back()->with('success', 'Activity logs cleared.');
    }
}
