<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'published_at',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }
}
