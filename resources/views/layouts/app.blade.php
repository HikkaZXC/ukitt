<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="app-container">
        <aside class="sidebar">
            <div style="text-align:center;">
                <a href="/" class="logo">UKITT</a>
            </div>
            
            <nav class="nav">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Главная
                </a>
                
                @auth
                    <a href="{{ route('profile.index') }}" class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        Профиль
                    </a>
                @endauth
            </nav>
            
            <div class="auth-section">
                @auth
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->surname }} {{ auth()->user()->name }}</div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">
                            <i class="fas fa-sign-out-alt"></i>
                            Выйти
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="auth-button">
                        <i class="fas fa-sign-in-alt"></i>
                        Войти
                    </a>
                @endauth
            </div>
        </aside>
        
        <main class="main-content">
            <div class="content-card">
                @include('components.breadcrumbs')
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
