<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $row = Cache::rememberForever('setting.'.$key, function () use ($key) {
            return self::query()->where('key', $key)->value('value');
        });

        return $row !== null ? $row : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        $stringValue = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) $value;
        self::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $stringValue]
        );
        Cache::forget('setting.'.$key);
    }

    public static function getJson(string $key, array $default = []): array
    {
        $raw = self::get($key);
        if ($raw === null || $raw === '') {
            return $default;
        }
        $decoded = json_decode((string) $raw, true);

        return is_array($decoded) ? $decoded : $default;
    }
}
