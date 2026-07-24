<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ValidationRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ValidationRuleController extends Controller
{
    public function index(): View
    {
        $rules = ValidationRule::latest()->get();

        return view('admin.validation-rules.index', compact('rules'));
    }

    public function create(): View
    {
        return view('admin.validation-rules.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'form_name' => ['required', 'string', 'max:255', 'unique:validation_rules,form_name'],
            'field_name' => ['required', 'string', 'max:255'],
            'rules' => ['required', 'string', 'max:500'],
            'custom_messages' => ['nullable', 'string', 'max:1000'],
        ]);

        $formName = $validated['form_name'];
        $fieldName = $validated['field_name'];
        $rulesArray = array_map('trim', explode('|', $validated['rules']));
        $messages = [];
        if (!empty($validated['custom_messages'])) {
            $lines = explode("\n", $validated['custom_messages']);
            foreach ($lines as $line) {
                if (str_contains($line, ':')) {
                    [$key, $value] = explode(':', $line, 2);
                    $messages[trim($key)] = trim($value);
                }
            }
        }

        $existing = ValidationRule::where('form_name', $formName)->first();
        if ($existing) {
            $rulesData = $existing->rules;
            $rulesData[$fieldName] = $rulesArray;
            $existing->update([
                'rules' => $rulesData,
                'custom_messages' => array_merge($existing->custom_messages ?? [], $messages),
            ]);
        } else {
            ValidationRule::create([
                'form_name' => $formName,
                'rules' => [$fieldName => $rulesArray],
                'custom_messages' => $messages,
            ]);
        }

        return redirect()->route('admin.validation-rules.index')
            ->with('success', 'Validation rule added successfully.');
    }

    public function edit(ValidationRule $validationRule): View
    {
        return view('admin.validation-rules.edit', ['rule' => $validationRule]);
    }

    public function update(Request $request, ValidationRule $validationRule): RedirectResponse
    {
        $validated = $request->validate([
            'rules' => ['required', 'json'],
            'custom_messages' => ['nullable', 'json'],
        ]);

        $validationRule->update([
            'rules' => json_decode($validated['rules'], true),
            'custom_messages' => !empty($validated['custom_messages']) ? json_decode($validated['custom_messages'], true) : null,
        ]);

        return redirect()->route('admin.validation-rules.index')
            ->with('success', 'Validation rules updated successfully.');
    }

    public function destroy(ValidationRule $validationRule): RedirectResponse
    {
        $validationRule->delete();

        return redirect()->route('admin.validation-rules.index')
            ->with('success', 'Validation rule deleted successfully.');
    }
}
