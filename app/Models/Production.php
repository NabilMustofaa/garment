<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_name',
        'production_description',
        'production_type',
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

    public function type()
    {
        return $this->belongsTo(production_type::class, 'production_type');
    }

    public function processMaterial()
    {
        return $this->hasMany(processMaterial::class);
    }

    

    


    

}
