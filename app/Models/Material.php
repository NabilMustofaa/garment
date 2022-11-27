<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;


    protected $fillable = [
        'material_name',
        'bagian_baju_id',
        'material_description',
        'material_quantity',
        'material_measure_unit',
        'material_type',
    ];

    public function production()
    {
        return $this->hasMany(Production::class);
    }

    public function processMaterial()
    {
        return $this->hasMany(ProcessMaterial::class);
    }

    public function bagianBaju()
    {
        return $this->belongsTo(bagian_baju::class);
    }
}
