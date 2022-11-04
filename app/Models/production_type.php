<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class production_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_type_name',
    ];

    public function production()
    {
        return $this->hasMany(Production::class);
    }

    public function production_process()
    {
        return $this->hasMany(production_process_type::class, 'production_type_id');
    }
}
