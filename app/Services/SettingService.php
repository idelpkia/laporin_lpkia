<?php

namespace App\Services;

// This service class provides methods to interact with system settings.
class SettingService
{
    public static function get($key, $default = null)
    {
        return \App\Models\SystemSetting::where('key', $key)->value('value') ?? $default;
    }

    // Penggunaan
    // use App\Services\SettingService;
    // SettingService::get('app_name')

    // Method to retrieve CSS color variables
    // Returns an associative array of CSS variable names and their corresponding values
    public static function getCSSColors()
    {
        return [
            '--primary' => self::get('primary_color', '#ad0505ff'),
            '--secondary' => self::get('secondary_color', '#ffa426'),
            '--success' => self::get('success_color', '#47c363'),
            '--danger' => self::get('danger_color', '#fc544b'),
        ];
    }
}
