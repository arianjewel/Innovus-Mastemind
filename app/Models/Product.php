<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends SluggableModel
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category_id', 'brand_id', 'sku', 'price', 'old_price',
        'unit', 'currency', 'short_desc', 'details', 'specifications',
        'is_featured', 'is_active', 'views', 'sort_order',
    ];

    protected $appends = ['category_name', 'brand_name', 'cover_url'];

    public function getCategoryNameAttribute(): ?string
    {
        return $this->category?->name;
    }

    public function getBrandNameAttribute(): ?string
    {
        return $this->brand?->name;
    }

    public function getCoverUrlAttribute(): string
    {
        $cover = $this->cover();

        return $cover
            ? asset('storage/' . $cover->path)
            : \App\Support\ImagePlaceholder::url($this->title, 640, 480);
    }

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'views' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function cover(): ?ProductImage
    {
        return $this->images->first();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
