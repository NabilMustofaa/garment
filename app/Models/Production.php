<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_name',
        'production_description',
        'production_status',
        'production_projected_end_date',
        'production_actual_end_date',
        'production_input_quantity',
        'production_material_id',
        'production_output_quantity',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function productionProcess()
    {
        return $this->hasMany(ProductionProcess::class);
    }

    

}
