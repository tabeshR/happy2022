<?php


namespace App\Helpers\Cart;


use Carbon\Laravel\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('cart',function (){
            return new CartService();
        });
    }
}
