<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProses extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_id',
        'process_material_id',
        'user_id',
        'sub_proses_name',
        'sub_proses_projected',
        'sub_proses_actual',
    ];

    public function processMaterial()
    {
        return $this->belongsTo(processMaterial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function subProcessHistories()
    {
        return $this->hasMany(SubProcessHistory::class, 'sub_process_id');
    }
}
