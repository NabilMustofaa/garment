<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProcessHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_process_id',
        'quantity',
    ];

    public function subProcess()
    {
        return $this->belongsTo(SubProses::class);
    }
}
