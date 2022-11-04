<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class production_process_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_type_id',
        'process_type_id',
    ];

    public function production_type()
    {
        return $this->belongsTo(production_type::class);
    }

    public function process_type()
    {
        return $this->belongsTo(process_type::class);
    }
    
}
