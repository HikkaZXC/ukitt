<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="d-flex">
        <header class="sidebar p-3" style="width: 240px; min-height: 100vh;">
            <div class="d-flex flex-column h-100">
                <div>
                    <h4 class="logo">{{ config('app.name') }}</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-newspaper me-2"></i>
                        Новости
                    </a>
                    @auth
                        @if (Auth::user()->role == 'admin')
                            <a class="nav-link {{ request()->routeIs('groups.*') ? 'active' : '' }}" href="#">
                                <i class="bi bi-people me-2"></i>
                                Группы
                            </a>
                            <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="#">
                                <i class="bi bi-person-vcard me-2"></i>
                                Студенты
                            </a>
                            <a class="nav-link {{ request()->routeIs('organizations.*') ? 'active' : '' }}" href="#">
                                <i class="bi bi-building me-2"></i>
                                Организации
                            </a>
                        @endif
                    @endauth
                    @auth
                        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                            <i class="bi bi-person-circle me-2"></i>
                            Профиль
                        </a>
                    @endauth
                </nav>

                <div class="mt-auto">
                    <div class="auth-section">
                        @auth
                            <div class="user-info">
                                <div class="user-name">{{ Auth::user()->surname }} {{ Auth::user()->name }}</div>
                                <div class="user-role">
                                    @switch(Auth::user()->role)
                                        @case('admin')
                                            Администратор
                                            @break
                                        @case('teacher')
                                            Преподаватель
                                            @break
                                        @case('student')
                                            Студент
                                            @break
                                        @default
                                            {{ Auth::user()->role }}
                                    @endswitch
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="logout-button">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Выйти
                                </button>
                            </form>
                        @else
                            <a class="auth-button" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Войти
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow-1 p-4">
            <div class="container-fluid">
                <div class="content-card p-4">
                    @if(isset($breadcrumbs))
                        <nav aria-label="breadcrumb">
                            <div class="breadcrumb">
                                <ol class="breadcrumb-items">
                                    @foreach($breadcrumbs as $breadcrumb)
                                        @if($loop->last)
                                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                                @if(request()->routeIs('profile.index'))
                                    <div class="breadcrumb-actions">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                            Редактировать профиль
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </nav>
                    @endif
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

</html>
