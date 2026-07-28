<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (File::isDirectory($backupPath)) {
            $files = File::files($backupPath);
            foreach ($files as $file) {
                $backups[] = [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'date' => $file->getMTime(),
                ];
            }
            usort($backups, fn($a, $b) => $b['date'] <=> $a['date']);
        }

        return view('admin.backup.index', compact('backups'));
    }

    public function create(): \Illuminate\Http\RedirectResponse
    {
        $backupPath = storage_path('app/backups');
        File::makeDirectory($backupPath, 0755, true, true);

        $filename = 'backup-' . now()->format('Y-m-d-His') . '.sql';
        $filepath = $backupPath . '/' . $filename;

        $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
        $sql = "-- Laravel Starter Kit Database Backup\n";
        $sql .= "-- Date: " . now()->format('Y-m-d H:i:s') . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->tablename;
            $rows = DB::table($tableName)->get();

            if ($rows->isEmpty()) continue;

            $sql .= "-- Table: {$tableName}\n";
            $sql .= "TRUNCATE TABLE \"{$tableName}\" CASCADE;\n";

            foreach ($rows as $row) {
                $rowArray = (array) $row;
                $columns = array_map(fn($k) => "\"{$k}\"", array_keys($rowArray));
                $values = array_map(fn($v) => $v === null ? 'NULL' : "'" . addslashes($v) . "'", array_values($rowArray));
                $sql .= "INSERT INTO \"{$tableName}\" (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }

        File::put($filepath, $sql);

        return back()->with('success', "Backup created: {$filename}");
    }

    public function download(string $filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filepath = storage_path("app/backups/{$filename}");

        if (!File::exists($filepath)) {
            abort(404);
        }

        return response()->download($filepath, $filename);
    }

    public function destroy(string $filename): \Illuminate\Http\RedirectResponse
    {
        $filepath = storage_path("app/backups/{$filename}");

        if (File::exists($filepath)) {
            File::delete($filepath);
        }

        return back()->with('success', 'Backup deleted successfully.');
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
