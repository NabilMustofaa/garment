<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colour extends Model
{
    use HasFactory;

    protected $fillable = [
        'colour_name',
        'colour_code',
    ];
}
