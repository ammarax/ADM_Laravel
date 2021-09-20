<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datetime extends Model
{
    use HasFactory;

    protected $casts = [
        "created" => 'datetime',
        "edited" => 'datetime',
    ];
}
