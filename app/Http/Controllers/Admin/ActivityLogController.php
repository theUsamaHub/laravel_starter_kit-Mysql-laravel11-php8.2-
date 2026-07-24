<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        $logs = $query->latest()->paginate(30);

        return view('admin.activity-logs.index', compact('logs'));
    }

    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        ActivityLog::query()->truncate();

        return back()->with('success', 'Activity logs cleared.');
    }
}
