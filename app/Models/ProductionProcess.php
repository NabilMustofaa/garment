<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'production_id',
        'process_id',
        'production_process_input_quantity',
        'production_process_output_quantity',
        'production_process_status',
        'production_process_start_date',
        'production_process_end_date',
        'production_process_message',
        
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
