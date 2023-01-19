<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'image_path',
    ];

    // protected $guarded = ['id'];

    protected $appends = [
        'image_url', // getImageUrlAttribute()
    ];

    protected $hidden = [
        'image_path', 'deleted_at', 'updated_at',
    ];

    protected static function booted()
    {
        // Global Scopes
        static::addGlobalScope('order', function($query) {
            $query->orderBy('categories.name');
        });
        // static::addGlobalScope('parent', function($query) {
        //     $query->whereNull('categories.parent_id');
        // });
    }

    // Local Scopes
    public function scopeNoParent($query)
    {
        $query->whereNull('categories.parent_id');
    }

    public function scopeSearch($query, $value)
    {
        if (!$value) {
            return;
        }
        $query->where('categories.name', 'LIKE', "%{$value}%");
    }
    
    // Accessors
    // $category->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('dashboard-assets/img/placeholder.png');
    }

    // echo $category->name
    public function getNameAttribute($value)
    {
        return Str::title($value);
    }

    // Mutators
    // $category->name = 'test';
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    // One-to-Many: One Category Has Many Products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    // One Category Has Many Child Categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    // One Category Belongs To One Parent Category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}
