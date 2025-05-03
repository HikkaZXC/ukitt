@extends('layouts.app')

@section('title', 'Редактирование: ' . $post->title)

@section('content')
<div class="section-header">
    <h2 class="section-title">Редактирование новости</h2>
    <a href="{{ route('post.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> К списку новостей
    </a>
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

<div class="post-form-container">
    <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data" class="post-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            <div class="form-text">Введите заголовок новости (до 255 символов)</div>
        </div>
        
        <div class="form-group">
            <label for="content" class="form-label">Содержание</label>
            <textarea class="form-control summernote" id="content" name="content" required>{{ old('content', $post->content) }}</textarea>
            <div class="form-text">Введите подробное содержание новости</div>
        </div>
        
        <div class="form-group">
            <label for="image" class="form-label">Изображение</label>
            <div class="file-input-wrapper">
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <div id="current-image" class="mt-3">
                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="preview-image">
                <p class="form-text mt-2">Текущее изображение. Загрузите новое, чтобы заменить.</p>
            </div>
            <div id="image-preview" class="mt-3 d-none">
                <img src="" alt="Предпросмотр" class="preview-image">
            </div>
            <div class="form-text">Загрузите новое изображение для новости (JPEG, PNG, GIF, JPG до 2MB)</div>
        </div>
        
        <div class="post-form-actions">
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
    
    .section-title {
        margin: 0;
        font-size: 1.5rem;
        position: relative;
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
    
    .post-form-container {
        margin-top: 1.5rem;
    }
    
    .post-form {
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
    
    textarea.form-control {
        resize: vertical;
        min-height: 150px;
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
        border: none;
        border-radius: 4px;
        color: var(--text-color);
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    input[type="file"].form-control::-webkit-file-upload-button:hover {
        background: var(--primary-color);
    }
    
    .preview-image {
        max-width: 300px;
        max-height: 200px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .post-form-actions {
        margin-top: 2.5rem;
        display: flex;
        justify-content: flex-end;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }
    
    .alert ul {
        padding-left: 1.5rem;
        margin: 0;
    }
    
    .alert li {
        margin-bottom: 0.25rem;
    }
    
    .alert li:last-child {
        margin-bottom: 0;
    }
    
    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .post-form {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Введите содержание новости...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            lang: 'ru-RU'
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const currentImage = document.getElementById('current-image');
        const previewImg = imagePreview.querySelector('img');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    currentImage.classList.add('d-none');
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection 