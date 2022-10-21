<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;


    protected $fillable = [
        'material_name',
        'material_description',
        'material_quantity',
        'material_measure_unit',
        'material_type',
    ];

    public function production()
    {
        return $this->hasMany(Production::class);
    }
}
