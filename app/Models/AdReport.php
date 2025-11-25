<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdReport extends Model
{
    protected $fillable = [
        'ad_id',
        'user_id',
        'reason',
        'message',
        'status',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
