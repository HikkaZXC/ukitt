@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-content">
        <div class="profile-section">
            <div class="profile-section-title">Личная информация</div>
            <div class="profile-row">
                <div class="profile-label">Фамилия</div>
                <div class="profile-value">{{ $user->surname }}</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Имя</div>
                <div class="profile-value">{{ $user->name }}</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Отчество</div>
                <div class="profile-value">{{ $user->patronymic ?? 'Не указано' }}</div>
            </div>
        </div>

        <div class="profile-section">
            <div class="profile-section-title">Контактная информация</div>
            <div class="profile-row">
                <div class="profile-label">Email</div>
                <div class="profile-value">{{ $user->email }}</div>
            </div>
            <div class="profile-row">
                <div class="profile-label">Роль</div>
                <div class="profile-value">
                    @switch($user->role)
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
                            {{ $user->role }}
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно редактирования профиля -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Редактирование профиля</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="surname" class="form-label">Фамилия</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ $user->surname }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="patronymic" class="form-label">Отчество</label>
                        <input type="text" class="form-control" id="patronymic" name="patronymic" value="{{ $user->patronymic }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
