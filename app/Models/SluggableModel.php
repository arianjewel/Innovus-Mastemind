<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class SluggableModel extends Model
{
    public function getSluggableSource(): string
    {
        return 'title';
    }

    protected static function bootSluggable(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug(
                    Str::slug($model->{$model->getSluggableSource()})
                );
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) && $model->isDirty($model->getSluggableSource())) {
                $model->slug = static::generateUniqueSlug(
                    Str::slug($model->{$model->getSluggableSource()}),
                    $model->id
                );
            }
        });
    }

    protected static function generateUniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base ?: Str::random(6);
        $original = $slug;
        $i = 1;

        while (
            static::query()
                ->when($ignoreId, fn (Builder $q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original.'-'.(++$i);
        }

        return $slug;
    }

    protected static function booted(): void
    {
        static::bootSluggable();
    }
}
