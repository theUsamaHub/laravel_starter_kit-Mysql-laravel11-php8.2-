<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IpRestrictionController extends Controller
{
    public function index(): View
    {
        $whitelist = Setting::get('ip_whitelist', []);
        $whitelist = is_array($whitelist) ? $whitelist : [];

        return view('admin.ip-restrictions.index', compact('whitelist'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ips' => 'nullable|string',
        ]);

        $ips = array_filter(array_map('trim', explode("\n", $validated['ips'] ?? '')));

        Setting::set('ip_whitelist', $ips, 'json');

        return back()->with('success', 'IP whitelist updated.');
    }
}
