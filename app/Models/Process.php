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
        'process_type',
        'process_status',
        'process_start_date',
        'process_end_date',
        'process_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function processMaterial()
    {
        return $this->hasMany(processMaterial::class);
    }

    public function type()
    {
        return $this->belongsTo(process_type::class, 'process_type');
    }

    public function subProses()
    {
        return $this->hasMany(SubProses::class);
    }

    
}
