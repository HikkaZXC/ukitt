<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Support\Str;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $breadcrumbs = $this->generateBreadcrumbs();
            $view->with('breadcrumbs', $breadcrumbs);
        });
    }

    protected function generateBreadcrumbs()
    {
        $breadcrumbs = [];
        $routeName = Route::currentRouteName();
        $routeParams = Route::current() ? Route::current()->parameters() : [];

        // Главная страница всегда в хлебных крошках
        $breadcrumbs[] = [
            'title' => 'Главная',
            'url' => route('home')
        ];

        // В зависимости от маршрута добавляем соответствующие элементы
        if ($routeName == 'home') {
            // Для главной страницы больше ничего не добавляем, только меняем последний элемент на активный
            $breadcrumbs[0]['active'] = true;
        } elseif ($routeName == 'post.show' && isset($routeParams['post'])) {
            $post = $routeParams['post'];
            $breadcrumbs[] = [
                'title' => $post->title,
                'url' => route('post.show', $post),
                'active' => true
            ];
        } elseif ($routeName == 'post.index') {
            // Управление новостями
            $breadcrumbs[] = [
                'title' => 'Управление новостями',
                'url' => route('post.index'),
                'active' => true
            ];
        } elseif ($routeName == 'post.create') {
            // Добавление новости
            $breadcrumbs[] = [
                'title' => 'Управление новостями',
                'url' => route('post.index')
            ];
            $breadcrumbs[] = [
                'title' => 'Создание новости',
                'url' => route('post.create'),
                'active' => true
            ];
        } elseif ($routeName == 'post.edit' && isset($routeParams['post'])) {
            // Редактирование новости
            $post = $routeParams['post'];
            $breadcrumbs[] = [
                'title' => 'Управление новостями',
                'url' => route('post.index')
            ];
            $breadcrumbs[] = [
                'title' => 'Редактирование: Post ' . $post->id,
                'url' => route('post.edit', $post),
                'active' => true
            ];
        } elseif ($routeName == 'profile.index') {
            $breadcrumbs[] = [
                'title' => 'Профиль',
                'url' => route('profile.index'),
                'active' => true
            ];
        } elseif ($routeName == 'login') {
            $breadcrumbs[] = [
                'title' => 'Вход',
                'url' => route('login'),
                'active' => true
            ];
        } elseif ($routeName == 'register') {
            $breadcrumbs[] = [
                'title' => 'Регистрация',
                'url' => route('register'),
                'active' => true
            ];
        }

        return $breadcrumbs;
    }
} 