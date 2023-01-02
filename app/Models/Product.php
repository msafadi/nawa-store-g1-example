<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'description', 'image_path', 'status',
        'price', 'compare_price', 'featured', 'reviews_avg', 'reviews_count'
    ];

    public function scopeActive($query)
    {
        $query->where('status', '=', 'active');
    }
}
