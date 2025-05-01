@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="content-card">
            <div class="p-4">
                <h2 class="text-center mb-4">Вход</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: var(--yandex-text-secondary);">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: var(--yandex-text-secondary);">Пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <label class="form-check-label" for="remember" style="color: var(--yandex-text-secondary);">Запомнить меня</label>
                    </div>
                    <button type="submit" class="auth-button w-100">Войти</button>
                </form>
                <div class="text-center mt-3">
                    <p style="color: var(--yandex-text-secondary);">Нет аккаунта? <a href="{{ route('register') }}" style="color: var(--yandex-primary); text-decoration: none;">Зарегистрироваться</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
