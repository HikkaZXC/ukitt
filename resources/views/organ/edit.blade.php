@extends('layouts.app')

@section('title', 'Редактирование организации')

@section('content')
<div class="section-header">
    <h2 class="section-title">Редактирование организации</h2>
    <div class="header-actions">
        <a href="{{ route('organ.show', $organ) }}" class="btn-secondary">
            <i class="fas fa-eye"></i> Просмотр
        </a>
        <a href="{{ route('organ.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> К списку организаций
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="organ-form-container">
    <form action="{{ route('organ.update', $organ) }}" method="POST" enctype="multipart/form-data" class="organ-form needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="form-label">Название организации</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $organ->name) }}" required>
            <div class="invalid-feedback">
                Пожалуйста, введите название организации.
            </div>
            @error('name')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-text">Введите название организации (до 255 символов)</div>
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $organ->email) }}" required>
            <div class="invalid-feedback">
                Пожалуйста, введите корректный email.
            </div>
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-text">Введите контактный email организации</div>
        </div>
        
        <div class="form-group">
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $organ->phone) }}" required>
            <div class="invalid-feedback">
                Пожалуйста, введите телефон.
            </div>
            @error('phone')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-text">Введите контактный телефон организации</div>
        </div>
        
        <div class="form-group">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $organ->address) }}" required>
            <div class="invalid-feedback">
                Пожалуйста, введите адрес.
            </div>
            @error('address')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-text">Введите фактический адрес организации</div>
        </div>
        
        <div class="form-group">
            <label for="logo" class="form-label">Логотип</label>
            @if($organ->logo)
                <div class="current-logo mb-3">
                    <p class="form-text mb-2">Текущий логотип:</p>
                    <img src="{{ asset($organ->logo) }}" alt="{{ $organ->name }}" class="logo-preview">
                </div>
            @endif
            <div class="file-input-wrapper">
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                @error('logo')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div id="logo-preview" class="mt-3 d-none">
                <p class="form-text mb-2">Новый логотип:</p>
                <img src="" alt="Предпросмотр" class="preview-image">
            </div>
            <div class="form-text">Загрузите новый логотип для организации или оставьте поле пустым, чтобы сохранить текущий</div>
        </div>
        
        <div class="organ-form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Сохранить изменения
            </button>
        </div>
    </form>
</div>

<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1.2rem;
        background: var(--secondary-color);
        color: var(--text-color);
        border: none;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: var(--bg-color);
        color: var(--text-color);
        transform: translateY(-2px);
    }
    
    .btn-secondary i {
        margin-right: 0.5rem;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1.2rem;
        background: var(--primary-color);
        color: var(--text-color);
        border: none;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .btn-primary i {
        margin-right: 0.5rem;
    }
    
    .organ-form-container {
        margin-top: 1.5rem;
    }
    
    .organ-form {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .form-group {
        margin-bottom: 1.75rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--bg-color);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text-color);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.2);
    }
    
    .form-text {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .file-input-wrapper {
        position: relative;
    }
    
    input[type="file"].form-control {
        padding: 0.5rem;
        background: var(--bg-color);
        cursor: pointer;
    }
    
    input[type="file"].form-control::-webkit-file-upload-button {
        padding: 0.5rem 1rem;
        margin-right: 1rem;
        background: var(--secondary-color);
        color: var(--text-color);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    #logo-preview, .current-logo {
        text-align: center;
    }
    
    .preview-image, .logo-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
    }
    
    .organ-form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
    }
    
    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 6px;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    
    .alert ul {
        padding-left: 1.25rem;
        margin-bottom: 0;
    }
    
    .d-block {
        display: block;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .mt-3 {
        margin-top: 1rem;
    }
    
    .mb-3 {
        margin-bottom: 1rem;
    }
    
    .mb-2 {
        margin-bottom: 0.5rem;
    }
    
    .d-none {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logo');
        const logoPreview = document.getElementById('logo-preview');
        const previewImage = logoPreview.querySelector('img');
        
        logoInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const url = URL.createObjectURL(file);
                previewImage.src = url;
                logoPreview.classList.remove('d-none');
            } else {
                logoPreview.classList.add('d-none');
            }
        });
        
        // Проверка валидности формы при отправке
        const form = document.querySelector('.organ-form');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
</script>
@endsection
