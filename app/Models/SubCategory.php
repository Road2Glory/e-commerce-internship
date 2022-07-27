<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'subCategory_name_en',
        'subCategory_name_fr',
        'subCategory_slug_en',
        'subCategory_slug_fr',
    ];
}
