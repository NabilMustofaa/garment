<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'quantity',
        'description',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
