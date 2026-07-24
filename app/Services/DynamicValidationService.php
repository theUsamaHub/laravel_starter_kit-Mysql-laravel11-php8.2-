<?php

namespace App\Services;

use App\Models\ValidationRule;

class DynamicValidationService
{
    /**
     * Get merged rules (hardcoded + dynamic) for a form.
     */
    public static function getRules(string $formName, array $baseRules = []): array
    {
        $dynamicRules = ValidationRule::getRules($formName);

        if (empty($dynamicRules)) {
            return $baseRules;
        }

        $merged = $baseRules;
        foreach ($dynamicRules as $field => $fieldRules) {
            if (isset($merged[$field])) {
                // Append dynamic rules to existing field rules
                $merged[$field] = array_unique(array_merge($merged[$field], $fieldRules));
            } else {
                // Add new field with dynamic rules
                $merged[$field] = $fieldRules;
            }
        }

        return $merged;
    }

    /**
     * Get merged custom messages for a form.
     */
    public static function getMessages(string $formName, array $baseMessages = []): array
    {
        $dynamicMessages = ValidationRule::getMessages($formName);
        return array_merge($baseMessages, $dynamicMessages);
    }

    /**
     * Get available form names that have dynamic rules.
     */
    public static function getFormNames(): array
    {
        return ValidationRule::pluck('form_name')->unique()->toArray();
    }

    /**
     * Get all fields and rules for a form.
     */
    public static function getFormFields(string $formName): array
    {
        $record = ValidationRule::where('form_name', $formName)->first();
        return $record?->rules ?? [];
    }
}
