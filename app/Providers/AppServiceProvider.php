<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Providers\BreadcrumbsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(BreadcrumbsServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('plural', function ($value, $count, array $words) {
            // Правильная плюрализация для русского языка
            $mod10 = $count % 10;
            $mod100 = $count % 100;
            
            if ($mod10 == 1 && $mod100 != 11) {
                return $words[0]; // 1, 21, 31, ... - новость
            } elseif ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) {
                return $words[1]; // 2-4, 22-24, ... - новости
            } else {
                return $words[2]; // 0, 5-20, 25-30, ... - новостей
            }
        });
        
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->password);
        }, 'Текущий пароль указан неверно.');
    }
}
