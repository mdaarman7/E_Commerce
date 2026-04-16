<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $count = 0;
            if (Auth::check() && Auth::user()->role == 'customer') 
            {
                $count = Cart::where('user_id', Auth::id())->sum('quantity');
            }
            $view->with('cartCount', $count);
        });
    }
}
