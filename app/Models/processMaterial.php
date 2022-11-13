<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class processMaterial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'process_id',
        'material_id',
        'process_material_name',
        'process_material_quantity',
        'process_material_status',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function subProses()
    {
        return $this->hasMany(SubProses::class);
    }



    
}
