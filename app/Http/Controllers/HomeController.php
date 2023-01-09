<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    // actions
    public function index()
    {
        $slides = [
            [
                'image' => 'https://via.placeholder.com/800x500',
                'title' => '<span>No restocking fee ($35 savings)</span> M75 Sport Watch',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
                'price' => '320.99',
                'link' => '#'
            ],
            [
                'image' => 'https://via.placeholder.com/800x500',
                'title' => '<span>Big Sale Offer</span> Get the Best Deal on CCTV Camera',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
                'price' => '590.00',
                'link' => '#'
            ],
            [
                'image' => 'https://via.placeholder.com/800x500',
                'title' => '<span>Sale Offer</span> Get the Best Deal on CCTV Camera',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
                'price' => '210.59',
                'link' => '#'
            ],
        ];

        $products = Product::with('category')->limit(8)->get();

        return view('front.index', [
            'title' => 'Home',
            'slides' => $slides,
            'products' => $products,
        ]);
    }

    public function show($name = 'default')
    {
        if (! View::exists("front.pages.$name")) {
            abort(404);
        }
        return view("front.pages.$name");
    }
}
