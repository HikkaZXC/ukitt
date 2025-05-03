<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Обрабатывает входящий запрос.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, авторизуйтесь.');
        }

        $user = Auth::user();
        $roles = $role ? explode('|', $role) : [];
        
        if (!empty($roles) && !in_array($user->role, $roles)) {
            return redirect()->route('home')->with('error', 'У вас нет доступа к этой странице.');
        }

        return $next($request);
    }
} 