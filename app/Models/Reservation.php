<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'member_id',
        'book_id',
        'reservation_date',
        'expired_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'reservation_date' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function reservationQueue(): HasOne
    {
        return $this->hasOne(ReservationQueue::class);
    }
}
