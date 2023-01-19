<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'description', 'image_path', 'status',
        'price', 'compare_price', 'featured', 'reviews_avg', 'reviews_count'
    ];

    protected $appends = [
        'image_url', // getImageUrlAttribute()
    ];

    protected $hidden = [
        'image_path', 'deleted_at', 'updated_at',
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

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
                return $this->image_path;
            }
            return asset('storage/' . $this->image_path);
        }
        return asset('dashboard-assets/img/placeholder.png');
    }

    public function getUrlAttribute()
    {
        return route('products.show', $this->slug);
    }
}
