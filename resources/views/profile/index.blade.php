@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-header">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-edit"></i>
            Редактировать профиль
        </button>
    </div>

    <div class="profile-section">
        <h3 class="profile-section-title">Личная информация</h3>
        <div class="profile-row">
            <div class="profile-label">ФИО</div>
            <div class="profile-value">{{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}</div>
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
                @endswitch
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h3 class="profile-section-title">Контактная информация</h3>
        <div class="profile-row">
            <div class="profile-label">Email</div>
            <div class="profile-value">{{ $user->email }}</div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование профиля</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Фамилия</label>
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $user->surname }}" required>
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Отчество</label>
                            <input type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ $user->patronymic }}">
                            @error('patronymic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
