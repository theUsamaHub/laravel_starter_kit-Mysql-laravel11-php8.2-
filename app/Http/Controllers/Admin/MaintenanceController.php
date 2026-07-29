<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        $isMaintenance = Setting::get('maintenance_mode', false);
        $message = Setting::get('maintenance_message', 'We are currently performing scheduled maintenance. We will be back shortly.');
        $bypassRoutes = Setting::get('maintenance_bypass_routes', 'login,register,forgot-password,reset-password*');

        return view('admin.maintenance.index', compact('isMaintenance', 'message', 'bypassRoutes'));
    }

    public function toggle(): RedirectResponse
    {
        $isMaintenance = Setting::get('maintenance_mode', false);
        Setting::set('maintenance_mode', !$isMaintenance, 'boolean');

        $status = !$isMaintenance ? 'enabled' : 'disabled';

        return redirect()->route('admin.maintenance.index')
            ->with('success', "Maintenance mode {$status} successfully.");
    }

    public function updateMessage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        Setting::set('maintenance_message', $validated['message'], 'text');

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance message updated successfully.');
    }

    public function updateBypassRoutes(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bypass_routes' => ['required', 'string', 'max:500'],
        ]);

        Setting::set('maintenance_bypass_routes', $validated['bypass_routes'], 'text');

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Bypass routes updated successfully.');
    }
}
