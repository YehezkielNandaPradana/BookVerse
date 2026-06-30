<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fine extends Model
{
    protected $fillable = [
        'return_id',
        'amount',
        'status',
        'description',
    ];

    public function borrowingReturn(): BelongsTo
    {
        return $this->belongsTo(BorrowingReturn::class, 'return_id');
    }

    public function finePayments(): HasMany
    {
        return $this->hasMany(FinePayment::class);
    }
}
