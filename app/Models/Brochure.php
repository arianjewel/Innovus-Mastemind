<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brochure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'pdf_path', 'size_bytes', 'downloads', 'is_active',
    ];

    protected $appends = ['url'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->latest();
    }

    public function url(): string
    {
        return Storage::url($this->pdf_path);
    }

    public function getUrlAttribute(): string
    {
        return $this->url();
    }
}
