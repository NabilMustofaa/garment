<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bagian_baju extends Model
{
    use HasFactory;

    protected $fillable = [
        'bagian_id',
        'ukuran_id',
        'production_id',
    
    ];
}
