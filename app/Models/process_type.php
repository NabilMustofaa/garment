<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class process_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_type_name',
    ];

    public function process()
    {
        return $this->hasMany(Process::class);
    }
}
