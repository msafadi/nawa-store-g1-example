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

    // Product Belong To One Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag',  // Pivot Table
            'product_id',   // FK for current model in pivot table
            'tag_id',       // FK related model in pivot table
            'id', // id in products
            'id', // id im tags
        );
    }
}
