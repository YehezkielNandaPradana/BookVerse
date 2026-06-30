<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrowing extends Model
{
    protected $fillable = [
        'member_id',
        'librarian_id',
        'borrow_date',
        'due_date',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(Librarian::class);
    }

    public function borrowingItems(): HasMany
    {
        return $this->hasMany(BorrowingItem::class);
    }

    public function return(): HasOne
    {
        return $this->hasOne(BorrowingReturn::class, 'borrowing_id');
    }
}
