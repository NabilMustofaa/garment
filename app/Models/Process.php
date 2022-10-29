<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'production_id',
        'process_name',
        'process_input_material_id',
        'process_input_quantity',
        'process_output_material_id',
        'process_output_quantity',
        'process_status',
        'process_start_date',
        'process_end_date',
        'process_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function process_input_material()
    {
        return $this->belongsTo(Material::class);
    }

    public function process_output_material()
    {
        return $this->belongsTo(Material::class);
    }

    
}
