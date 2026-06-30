<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinePayment extends Model
{
    protected $fillable = [
        'fine_id',
        'payment_date',
        'amount',
        'method',
        'proof',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
        ];
    }

    public function fine(): BelongsTo
    {
        return $this->belongsTo(Fine::class);
    }
}
