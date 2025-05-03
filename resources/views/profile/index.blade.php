@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="profile-wrapper">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <div class="profile-avatar-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->surname, 0, 1)) }}
                    </div>
                </div>
                <h3 class="profile-name">{{ $user->surname }} {{ $user->name }}</h3>
                <div class="profile-role">
                    @switch($user->role)
                        @case('admin')
                            <i class="fas fa-user-shield"></i> Администратор
                            @break
                        @case('teacher')
                            <i class="fas fa-chalkboard-teacher"></i> Преподаватель
                            @break
                        @case('student')
                            <i class="fas fa-user-graduate"></i> Студент
                            @break
                        @case('organ')
                            <i class="fas fa-building"></i> Организация
                            @break
                    @endswitch
                </div>
                <div class="profile-actions">
                    <button type="button" class="btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit"></i> Редактировать профиль
                    </button>
                </div>
            </div>

            <div class="profile-content">
                <div class="profile-card">
                    <div class="profile-card-header">
                        <i class="fas fa-user profile-card-icon"></i>
                        <h4>Личная информация</h4>
                    </div>
                    <div class="profile-card-body">
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <i class="fas fa-id-card"></i> Полное имя
                            </div>
                            <div class="profile-info-value">
                                {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}
                            </div>
                        </div>
                        
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <i class="fas fa-envelope"></i> Email
                            </div>
                            <div class="profile-info-value">
                                {{ $user->email }}
                            </div>
                        </div>
                        
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <i class="fas fa-calendar-alt"></i> Дата регистрации
                            </div>
                            <div class="profile-info-value">
                                {{ $user->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-card">
                    <div class="profile-card-header">
                        <i class="fas fa-shield-alt profile-card-icon"></i>
                        <h4>Безопасность</h4>
                    </div>
                    <div class="profile-card-body">
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <i class="fas fa-lock"></i> Пароль
                            </div>
                            <div class="profile-info-value">
                                <span class="password-dots">••••••••</span>
                                <button type="button" class="btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    Изменить пароль
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-user-edit me-2"></i>Редактирование профиля
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Фамилия</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $user->surname }}" required>
                                </div>
                                @error('surname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Имя</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Отчество</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ $user->patronymic }}">
                                </div>
                                @error('patronymic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-1"></i> Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Change Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-lock me-2"></i>Изменение пароля
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Текущий пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Новый пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-white">
                                    Пароль должен содержать минимум 8 символов, включая заглавные и строчные буквы, цифры и специальные символы.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Подтвердите новый пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-1"></i> Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
