<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogViewerController extends Controller
{
    public function index(): View
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            $lines = static::tailFile($logPath, 200);
            $logs = array_reverse(array_filter($lines));
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

    public function download(): StreamedResponse
    {
        $logPath = storage_path('logs/laravel.log');
        return response()->download($logPath, 'laravel-' . now()->format('Y-m-d-His') . '.log');
    }

    private static function tailFile(string $path, int $lines): array
    {
        $file = new \SplFileObject($path, 'r');
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();

        $startLine = max(0, $totalLines - $lines);
        $file->seek($startLine);

        $result = [];
        while ($file->valid() && $file->key() < $totalLines) {
            $result[] = rtrim($file->current(), "\r\n");
            $file->next();
        }

        return $result;
    }
}
