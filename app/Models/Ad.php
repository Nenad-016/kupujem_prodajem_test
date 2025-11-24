<?php

namespace App\Models;

use App\Enums\AdCondition;
use App\Enums\AdStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'condition',
        'image_path',
        'phone',
        'location',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'condition' => AdCondition::class,
        'status' => AdStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
