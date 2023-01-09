<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    public function index()
    {
        $cart = App::make(CartRepository::class);
        return view('front.cart', [
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $cart = App::make(CartRepository::class);
        $cart->add( 
            $request->post('product_id'),
            $request->post('quantity', 1)
        );

        return redirect()->back()->with('success', 'Product added to cart.');
    }
}
