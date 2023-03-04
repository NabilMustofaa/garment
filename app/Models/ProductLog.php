<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'process_id',
        'user_id',
        'accepted_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
