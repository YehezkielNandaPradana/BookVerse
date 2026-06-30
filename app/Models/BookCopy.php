<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookCopy extends Model
{
    protected $fillable = [
        'book_id',
        'shelf_id',
        'copy_code',
        'barcode',
        'condition',
        'status',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function borrowingItems(): HasMany
    {
        return $this->hasMany(BorrowingItem::class);
    }
}
