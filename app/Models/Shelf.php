<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shelf extends Model
{
    protected $fillable = [
        'code',
        'name',
        'floor',
        'description',
    ];

    public function bookCopies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }
}
