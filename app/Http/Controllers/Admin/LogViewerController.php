<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LogViewerController extends Controller
{
    public function index(): View
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            $content = File::tail($logPath, 200);
            $logs = array_reverse(array_filter(explode("\n", $content)));
        }

        return view('admin.logs.index', compact('logs'));
    }

    public function clear(): \Illuminate\Http\RedirectResponse
    {
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            File::put($logPath, '');
        }

        return back()->with('success', 'Logs cleared successfully.');
    }

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $logPath = storage_path('logs/laravel.log');
        return response()->download($logPath, 'laravel-' . now()->format('Y-m-d-His') . '.log');
    }
}
