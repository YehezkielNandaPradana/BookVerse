<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'library_name',
        'logo',
        'favicon',
        'borrow_limit',
        'borrow_duration',
        'fine_per_day',
        'address',
        'phone',
        'email',
    ];
}
