<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartRepository
{
    protected $cookie_id;

    public function __construct($cookie_id)
    {
        $this->cookie_id = $cookie_id;
    }

    public function get()
    {
        return Cart::where('cookie_id', '=', $this->cookie_id)
            ->with('product')
            ->get(); // Collection
    }

    public function add($id, $qty = 1)
    {
        $cart = Cart::where([
            'cookie_id' => $this->cookie_id,
            'product_id' => $id
        ])->first();

        if ($cart) {
            $cart->increment('quantity', $qty);
            return $cart;
        }

        return Cart::create([
            'id' => Str::uuid(),
            'cookie_id' => $this->cookie_id,
            'product_id' => $id,
            'quantity' => $qty,
            'user_id' => Auth::id(),
        ]);
    }

    public function remove($id)
    {
        Cart::where([
            'cookie_id' => $this->cookie_id,
            'product_id' => $id
        ])->delete();
    }

    public function empty()
    {
        Cart::where('cookie_id', '=', $this->cookie_id)->delete();
    }

    public function total()
    {
        $cart = $this->get(); // Collection
        return $cart->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}