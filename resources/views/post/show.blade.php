@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="section-header">
    <h2 class="section-title">{{ $post->title }}</h2>
    <a href="{{ route('home') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> На главную
    </a>
</div>

<div class="post-detail-container">
            <div class="post-meta">
        <div class="post-meta-item">
            <i class="fas fa-user"></i> Автор: {{ $post->user->name }}
                </div>
        <div class="post-meta-item">
            <i class="far fa-calendar-alt"></i> Опубликовано: {{ $post->created_at->format('d.m.Y H:i') }}
                </div>
        <div class="post-meta-item">
            <i class="fas fa-edit"></i> Обновлено: {{ $post->updated_at->format('d.m.Y H:i') }}
            </div>
        </div>
        
    <div class="post-image-wrapper">
        <div class="post-image-container">
            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="post-image">
        </div>
        </div>
        
        <div class="post-content">
            {!! $post->content !!}
        </div>
</div>

@auth
    @if(auth()->user()->role === 'admin')
    <div class="post-admin-actions">
        <a href="{{ route('post.edit', $post) }}" class="btn-primary">
            <i class="fas fa-edit"></i> Редактировать
        </a>
        <form action="{{ route('post.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">
                <i class="fas fa-trash"></i> Удалить
            </button>
        </form>
        </div>
    @endif
@endauth

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
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.3;
        color: var(--primary-color);
    }
    
    .post-detail-container {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .post-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .post-meta-item {
        display: flex;
        align-items: center;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }
    
    .post-meta-item i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }
    
    .post-image-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }
    
    .post-image-container {
        max-width: 800px;
        max-height: 500px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .post-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
        display: block;
    }
    
    .post-content {
        font-size: 1.05rem;
        line-height: 1.7;
        color: var(--text-color);
    }
    
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    .post-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }
    
    .post-content table, .post-content th, .post-content td {
        border: 1px solid var(--border-color);
    }
    
    .post-content th, .post-content td {
        padding: 0.5rem;
    }
    
    .post-admin-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
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
    
    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1.2rem;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-2px);
    }
    
    .btn-danger i {
        margin-right: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .post-detail-container {
            padding: 1.5rem;
        }
        
        .post-meta {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .post-image-container {
            max-height: 300px;
        }
        
        .post-image {
            max-height: 300px;
        }
        
        .post-admin-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .post-admin-actions .btn-primary,
        .post-admin-actions .btn-danger {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection 