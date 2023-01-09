<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cart.cookie_id', function () {
            $cookie_id = Cookie::get('cart_id');
            if (!$cookie_id) {
                $cookie_id = Str::uuid();
                Cookie::queue('cart_id', $cookie_id, 60*24*30);
            }
            return $cookie_id;
        });

        $this->app->bind(CartRepository::class, function ($app) {
            return new CartRepository($app->make('cart.cookie_id'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
