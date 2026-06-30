<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationQueue extends Model
{
    protected $table = 'reservation_queue';

    protected $fillable = [
        'reservation_id',
        'queue_number',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
