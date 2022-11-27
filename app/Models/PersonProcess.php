<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonProcess extends Model
{
    use HasFactory;

    protected $table = 'person_processes';
    protected $fillable = [
        'user_id',
        'process_type_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function process_type()
    {
        return $this->belongsTo(process_type::class);
    }
}
