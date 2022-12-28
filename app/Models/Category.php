<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'image_path',
    ];

    // protected $guarded = ['id'];
    
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
}
