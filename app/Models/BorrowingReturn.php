<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BorrowingReturn extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'borrowing_id',
        'returned_by',
        'return_date',
        'late_days',
        'total_fine',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'return_date' => 'date',
        ];
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class, 'return_id');
    }
}
