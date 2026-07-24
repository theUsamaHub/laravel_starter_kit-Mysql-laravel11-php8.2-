<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        $isMaintenance = Cache::get('maintenance_mode', false);
        $message = Cache::get('maintenance_message', 'We are currently performing scheduled maintenance. We will be back shortly.');

        return view('admin.maintenance', compact('isMaintenance', 'message'));
    }

    public function toggle(): RedirectResponse
    {
        $isMaintenance = Cache::get('maintenance_mode', false);
        Cache::put('maintenance_mode', !$isMaintenance);

        $status = !$isMaintenance ? 'enabled' : 'disabled';

        return redirect()->route('admin.maintenance.index')
            ->with('success', "Maintenance mode {$status} successfully.");
    }

    public function updateMessage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        Cache::put('maintenance_message', $validated['message']);

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance message updated successfully.');
    }
}
