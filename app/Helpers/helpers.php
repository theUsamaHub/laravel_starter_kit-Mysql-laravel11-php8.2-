<?php

use Illuminate\Support\Str;

if (!function_exists('generate_slug')) {
    /**
     * Generate a URL-friendly slug from a string.
     */
    function generate_slug(string $text): string
    {
        return Str::slug($text);
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date using Carbon.
     */
    function format_date($date, string $format = 'M d, Y'): string
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        return $date->format($format);
    }
}

if (!function_exists('time_ago')) {
    /**
     * Get a human-readable "time ago" string.
     */
    function time_ago($date): string
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        return $date->diffForHumans();
    }
}

if (!function_exists('get_initials')) {
    /**
     * Get initials from a name (max 2 characters).
     */
    function get_initials(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(mb_substr($word, 0, 1));
        }
        return $initials;
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text to a specified length with an ellipsis.
     */
    function truncate_text(string $text, int $length = 100): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length) . '...';
    }
}
