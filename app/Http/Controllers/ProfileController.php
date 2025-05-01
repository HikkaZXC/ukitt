<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Профиль', 'url' => route('profile.index')]
        ];
        return view('profile.index', compact('user', 'breadcrumbs'));
    }

    public function edit()
    {
        $user = Auth::user();
        $breadcrumbs = [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Профиль', 'url' => route('profile.index')],
            ['title' => 'Редактирование', 'url' => route('profile.edit')]
        ];
        return view('profile.edit', compact('user', 'breadcrumbs'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());

        return redirect()->route('profile.index')
            ->with('success', 'Профиль успешно обновлен');
    }
}
