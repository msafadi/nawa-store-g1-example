<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaymentsController extends Controller
{

    protected function client()
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);
        return $client;
    }

    public function redirect($order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->payment_status == 'paid') {
            return redirect()->route('home');
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->id,
                "amount" => [
                    "value" =>$order->total,
                    "currency_code" => $order->currency_code,
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('payments.cancel', $order->id),
                "return_url" => route('payments.callback', $order->id),
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $client = $this->client();
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);
            if ($response->statusCode == 201) {
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }

        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function callback(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->payment_status == 'paid') {
            return redirect()->route('home');
        }

        $paypal_order_id = $request->query('token');
        if (!$paypal_order_id) {
            abort(404);
        }

        $captureRequest = new OrdersCaptureRequest($paypal_order_id);
        $captureRequest->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $client = $this->client();
            $response = $client->execute($captureRequest);
            
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);
            if ($response->statusCode == 201 && $response->result->status == 'COMPLETED') {
                $order->update([
                    'payment_status' => 'paid',
                ]);
                return redirect()->route('home');
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function cancel()
    {

    }
}
