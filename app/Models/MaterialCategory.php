<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_name',
    ];

    public function materialSubCategory()
    {
        return $this->hasMany(MaterialSubCategory::class);
    }
    
}
