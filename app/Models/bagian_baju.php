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
        'colour_id',
        'production_id',
    
    ];

    public function bagian()
    {
        return $this->belongsTo(bagian::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(ukuran::class);
    }

    public function colour()
    {
        return $this->belongsTo(colour::class);
    }
}
