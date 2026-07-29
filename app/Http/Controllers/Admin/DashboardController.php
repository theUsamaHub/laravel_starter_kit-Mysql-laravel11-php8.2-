<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Media;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = $this->getStats();

        $chartData = $this->getChartData();

        $activityToday = $this->getActivityToday();

        $recentUsers = User::with('roles')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'chartData', 'activityToday', 'recentUsers'));
    }

    private function getStats(): array
    {
        $contactCounts = Contact::selectRaw("count(*) as total")
            ->selectRaw("count(case when status = 'new' then 1 end) as new_count")
            ->first();

        return [
            ['label' => __('Users'), 'count' => User::count(), 'icon' => 'bi-people', 'color' => 'primary', 'route' => 'admin.users.index'],
            ['label' => __('Categories'), 'count' => Category::count(), 'icon' => 'bi-tags', 'color' => 'success', 'route' => 'admin.categories.index'],
            ['label' => __('Contacts'), 'count' => $contactCounts->total, 'icon' => 'bi-envelope', 'color' => 'info', 'route' => 'admin.contacts.index', 'badge' => $contactCounts->new_count],
            ['label' => __('Tags'), 'count' => Tag::count(), 'icon' => 'bi-bookmark', 'color' => 'warning', 'route' => 'admin.tags.index'],
            ['label' => __('Roles'), 'count' => Role::count(), 'icon' => 'bi-shield-check', 'color' => 'secondary', 'route' => 'admin.roles.index'],
            ['label' => __('Media'), 'count' => Media::count(), 'icon' => 'bi-folder', 'color' => 'dark', 'route' => 'admin.media.index'],
        ];
    }

    private function getChartData(): array
    {
        $userCounts = User::selectRaw("DATE(created_at) as date, count(*) as count")
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->pluck('count', 'date');

        $contactCounts = Contact::selectRaw("DATE(created_at) as date, count(*) as count")
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->pluck('count', 'date');

        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $dateKey = $date->toDateString();
            $days[] = [
                'label' => $date->format('M d'),
                'users' => (int) ($userCounts[$dateKey] ?? 0),
                'contacts' => (int) ($contactCounts[$dateKey] ?? 0),
            ];
        }

        return $days;
    }

    private function getActivityToday(): array
    {
        $events = ActivityLog::selectRaw("event, count(*) as count")
            ->whereDate('created_at', today())
            ->groupBy('event')
            ->pluck('count', 'event');

        $total = $events->sum();

        return [
            'total' => $total,
            'created' => (int) ($events['created'] ?? 0),
            'updated' => (int) ($events['updated'] ?? 0),
            'deleted' => (int) ($events['deleted'] ?? 0),
        ];
    }
}
