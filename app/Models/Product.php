<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'material_id',
        'production_id',
        'current_process_id',
        'permak',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function productLog()
    {
        return $this->hasMany(ProductLog::class);
    }
}
