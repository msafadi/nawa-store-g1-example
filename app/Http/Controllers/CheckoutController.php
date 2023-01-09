<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        return view('front.checkout',[
            'countries' => Countries::getNames(),
            'cart' => $cart,
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'nullable|string|size:10',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country_code' => 'required|string|size:2',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['total'] = $cart->total();
        $validated['currency_code'] = config('app.currency');

        DB::beginTransaction();
        try {
            $order = Order::create($validated);
            foreach ($cart->get() as $item) {
                $order->items()->create([
                    //'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()
            ->route('payments.redirect', $order->id);
    }
}
