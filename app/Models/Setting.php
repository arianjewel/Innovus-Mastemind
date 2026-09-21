<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::query()->where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->value) {
            null => $default,
            'true' => true,
            'false' => false,
            default => $setting->value,
        };
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : (string) $value]
        );
    }

    public static function getMany(array $keys, array $defaults = []): array
    {
        $values = static::query()->whereIn('key', $keys)->pluck('value', 'key')->all();

        return collect($keys)
            ->mapWithKeys(fn ($key) => [
                $key => Arr::get($values, $key, Arr::get($defaults, $key)),
            ])
            ->all();
    }

    public static function getManyDecoded(array $keys, array $defaults = []): array
    {
        $values = static::getMany($keys, $defaults);

        foreach ($values as $key => $value) {
            if (is_string($value) && str_starts_with($value, '[') && json_validate($value)) {
                $values[$key] = json_decode($value, true);
            }
        }

        return $values;
    }
}
