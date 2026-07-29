<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Illuminate\View\View;

class HealthController extends Controller
{
    public function index(): View
    {
        $health = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => app()->environment(),
            'debug_enabled' => config('app.debug'),
            'url' => config('app.url'),
            'timezone' => config('app.timezone'),
            'locale' => app()->getLocale(),

            'database' => $this->checkDatabase(),
            'cache_driver' => config('cache.default'),
            'cache_reachable' => $this->checkCache(),
            'queue_connection' => config('queue.default'),
            'session_driver' => config('session.driver'),
            'filesystem_disk' => config('filesystems.default'),

            'storage_total' => $this->formatBytes(disk_total_space(storage_path())),
            'storage_free' => $this->formatBytes(disk_free_space(storage_path())),
            'storage_usage_pct' => $this->diskUsagePercent(storage_path()),
            'public_storage_link' => file_exists(public_path('storage')),

            'failed_jobs_count' => $this->getFailedJobsCount(),
            'jobs_table_exists' => $this->tableExists('jobs'),

            'uptime' => $this->getUptime(),
            'memory_usage' => $this->formatBytes(memory_get_usage(true)),
            'peak_memory' => $this->formatBytes(memory_get_peak_usage(true)),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        ];

        return view('admin.health.index', compact('health'));
    }

    private function checkDatabase(): string
    {
        try {
            DB::connection()->getPdo();
            return 'connected';
        } catch (\Exception $e) {
            return 'error: ' . $e->getMessage();
        }
    }

    private function checkCache(): bool
    {
        try {
            Cache::store(config('cache.default'))->has('health-check-key');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getFailedJobsCount(): int
    {
        try {
            return DB::table('failed_jobs')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function tableExists(string $table): bool
    {
        try {
            return DB::connection()->getSchemaBuilder()->hasTable($table);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getUptime(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            try {
                $uptime = exec('wmic os get lastbootuptime 2>&1');
                if ($uptime) {
                    $lines = explode("\n", trim($uptime));
                    if (count($lines) > 1) {
                        $boot = $lines[1];
                        $timestamp = strtotime(substr($boot, 0, 14));
                        if ($timestamp) {
                            $diff = time() - $timestamp;
                            return $this->formatDuration($diff);
                        }
                    }
                }
            } catch (\Exception $e) {}
            return 'N/A';
        }

        $uptime = @file_get_contents('/proc/uptime');
        if ($uptime) {
            $seconds = (float) strtok($uptime, ' ');
            return $this->formatDuration($seconds);
        }

        return 'N/A';
    }

    private function formatDuration(float $seconds): string
    {
        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        $parts = [];
        if ($days > 0) $parts[] = $days . 'd';
        if ($hours > 0) $parts[] = $hours . 'h';
        $parts[] = $minutes . 'm';

        return implode(' ', $parts);
    }

    private function diskUsagePercent(string $path): string
    {
        $total = @disk_total_space($path);
        $free = @disk_free_space($path);
        if ($total && $free) {
            $pct = round((1 - $free / $total) * 100, 1);
            return $pct . '%';
        }
        return 'N/A';
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
