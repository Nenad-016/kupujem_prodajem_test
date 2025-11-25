<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFullPathAttribute(): string
    {
        $parts = [];
        $current = $this;

        while ($current) {
            array_unshift($parts, $current->name);
            $current = $current->parent;
        }

        return implode(' → ', $parts);
    }

    public function allAdsCount(): int
    {
        if ($this->children()->exists()) {
            return $this->children
                ->map(fn ($child) => $child->allAdsCount())
                ->sum();
        }

        return $this->ads()->count();
    }

    public function allCategoryIds(): array
    {
        $ids = [$this->id];

        $children = $this->relationLoaded('children')
            ? $this->children
            : $this->children()->get();

        foreach ($children as $child) {
            $ids = array_merge($ids, $child->allCategoryIds());
        }

        return $ids;
    }
}
