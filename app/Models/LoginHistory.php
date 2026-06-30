<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginHistory extends Model
{
    public $timestamps = false;

    protected $table = 'login_histories';

    protected $fillable = [
        'user_id',
        'ip_address',
        'device',
        'browser',
        'platform',
        'login_at',
        'logout_at',
    ];

    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
            'logout_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
