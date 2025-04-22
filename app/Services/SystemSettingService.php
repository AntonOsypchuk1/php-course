<?php

namespace App\Services;

use App\Models\SystemSetting;

class SystemSettingService
{
    public function get(string $key): ?string
    {
        return SystemSetting::where('key', $key)->value('value');
    }

    public function set(string $key, string $value): void
    {
        SystemSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function all(): array
    {
        return SystemSetting::pluck('value', 'key')->toArray();
    }
}
