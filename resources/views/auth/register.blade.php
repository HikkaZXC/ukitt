@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="content-card">
            <div class="p-4">
                <h2 class="text-center mb-4">Регистрация</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="surname" class="form-label" style="color: var(--yandex-text-secondary);">Фамилия</label>
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: var(--yandex-text-secondary);">Имя</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="patronymic" class="form-label" style="color: var(--yandex-text-secondary);">Отчество</label>
                        <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" name="patronymic" value="{{ old('patronymic') }}" required autocomplete="patronymic" style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('patronymic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: var(--yandex-text-secondary);">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: var(--yandex-text-secondary);">Пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" style="background: var(--yandex-hover); border: 1px solid rgba(255, 255, 255, 0.1); color: var(--yandex-text);">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="auth-button w-100">Зарегистрироваться</button>
                </form>
                <div class="text-center mt-3">
                    <p style="color: var(--yandex-text-secondary);">Уже есть аккаунт? <a href="{{ route('login') }}" style="color: var(--yandex-primary); text-decoration: none;">Войти</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
