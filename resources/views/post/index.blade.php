@extends('layouts.app')

@section('title', 'Управление новостями')

@section('content')
<div class="section-header">
    <h2 class="section-title">Управление новостями</h2>
    <a href="{{ route('post.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Добавить новость
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

<div class="news-admin-panel">
    <div class="news-list-header">
        <div class="post-count">Всего новостей: {{ $posts->total() }}</div>
    </div>
    
    @if($posts->count() > 0)
        <div class="news-admin-list">
            @foreach($posts as $post)
                <div class="news-item">
                    <div class="news-item-grid">
                        <div class="news-item-image-container">
                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="news-item-image">
                        </div>
                        <div class="news-item-content">
                            <h3 class="news-item-title">{{ $post->title }}</h3>
                            <div class="news-item-meta">
                                <span class="news-item-author">
                                    <i class="fas fa-user"></i> {{ $post->user->name }}
                                </span>
                                <span class="news-item-date">
                                    <i class="far fa-calendar-alt"></i> {{ $post->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            <p class="news-item-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}</p>
                        </div>
                        <div class="news-item-actions">
                            <a href="{{ route('post.show', $post) }}" class="news-action-btn" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('post.edit', $post) }}" class="news-action-btn" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('post.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="news-action-btn news-action-btn-delete" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pagination-container">
            {{ $posts->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3>Новости отсутствуют</h3>
            <p>Создайте первую новость, нажав на кнопку "Добавить новость"</p>
        </div>
    @endif
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
        color: var(--text-color);
    }
    
    .btn-primary i {
        margin-right: 0.5rem;
    }
    
    .news-admin-panel {
        margin-top: 1rem;
    }
    
    .news-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 0.75rem 1rem;
        background: var(--card-bg);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .post-count {
        font-weight: 500;
        color: var(--text-secondary);
    }
    
    .news-admin-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .news-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .news-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .news-item-grid {
        display: grid;
        grid-template-columns: 200px 1fr auto;
        gap: 1rem;
    }
    
    @media (max-width: 992px) {
        .news-item-grid {
            grid-template-columns: 150px 1fr auto;
        }
    }
    
    @media (max-width: 768px) {
        .news-item-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
        
        .news-item-actions {
            flex-direction: row !important;
            justify-content: flex-start !important;
            margin-top: 1rem;
        }
    }
    
    .news-item-image-container {
        height: 100%;
        overflow: hidden;
    }
    
    .news-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .news-item-content {
        padding: 1.25rem 0;
    }
    
    .news-item-title {
        font-size: 1.2rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    .news-item-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    .news-item-meta i {
        margin-right: 0.3rem;
        color: var(--primary-color);
    }
    
    .news-item-excerpt {
        color: var(--text-secondary);
        margin-bottom: 0;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .news-item-actions {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        gap: 0.75rem;
    }
    
    .news-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: var(--secondary-color);
        color: var(--text-color);
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .news-action-btn:hover {
        background: var(--primary-color);
        transform: scale(1.1);
    }
    
    .news-action-btn-delete:hover {
        background: #dc2626;
    }
    
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: var(--card-bg);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-state p {
        color: var(--text-secondary);
    }
    
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .alert i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }
    
    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #10b981;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }
</style>
@endsection 