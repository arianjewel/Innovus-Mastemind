<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends SluggableModel
{
    use HasFactory;

    public const TYPES = ['consultancy', 'construction', 'supply'];

    protected $fillable = [
        'title', 'slug', 'type', 'client', 'location', 'period',
        'contract_amount', 'overview', 'scope', 'image_path', 'gallery',
        'status', 'is_featured', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'scope' => 'array',
            'gallery' => 'array',
            'contract_amount' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class)->orderBy('sort_order');
    }
}
