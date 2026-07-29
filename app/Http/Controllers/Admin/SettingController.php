<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        $grouped = $settings->groupBy('group');

        return view('admin.settings.index', compact('grouped'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
        ]);

        foreach ($validated['settings'] as $key => $value) {
            $record = Setting::where('key', $key)->first();
            if (!$record) {
                continue;
            }

            // Skip empty password to keep existing
            if ($key === 'mail_password' && empty($value)) {
                continue;
            }

            if ($key === 'mail_additional_emails' && is_array($value)) {
                $value = json_encode(array_values($value));
            }

            $typedValue = match ($record->type) {
                'boolean' => $value ? '1' : '0',
                'json' => is_string($value) ? $value : json_encode($value),
                default => $value,
            };
            $record->update(['value' => $typedValue]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', 'unique:settings,key'],
            'value' => ['nullable', 'string'],
            'type' => ['required', 'in:text,textarea,number,boolean,image,json'],
        ]);

        Setting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    public function destroy(Setting $setting): RedirectResponse
    {
        $setting->delete();

        return back()->with('success', 'Setting deleted successfully.');
    }
}
