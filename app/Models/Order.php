<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'phone_numner',
        'address', 'city', 'postal_code', 'state', 'country_code',
        'status', 'payment_status', 'total', 'currency_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
