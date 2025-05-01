<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    protected $roles;

    public function __construct($roles)
    {
        $this->roles = is_array($roles) ? $roles : [$roles];
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, авторизуйтесь.');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, $this->roles)) {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице.');
        }

        return $next($request);
    }
}