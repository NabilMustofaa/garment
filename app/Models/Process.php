<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_name',
        'process_location',
        'process_description',

    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    
    
}
