@extends('layouts.app')

@section('title', 'Управление организациями')

@section('content')
<div class="section-header">
    <h2 class="section-title">Управление организациями</h2>
    <a href="{{ route('organ.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Добавить организацию
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

<div class="organ-admin-panel">
    <div class="organ-list-header">
        <div class="organ-count">Всего организаций: {{ $organizations->total() }}</div>
    </div>
    
    @if($organizations->count() > 0)
        <div class="organ-admin-list">
            @foreach($organizations as $organization)
                <div class="organ-item">
                    <div class="organ-item-grid">
                        <div class="organ-item-image-container">
                            <img src="{{ asset($organization->logo) }}" alt="{{ $organization->name }}" class="organ-item-image">
                        </div>
                        <div class="organ-item-content">
                            <h3 class="organ-item-title">{{ $organization->name }}</h3>
                            <div class="organ-item-meta">
                                <span class="organ-item-email">
                                    <i class="fas fa-envelope"></i> {{ $organization->email }}
                                </span>
                                <span class="organ-item-phone">
                                    <i class="fas fa-phone"></i> {{ $organization->phone }}
                                </span>
                            </div>
                            <p class="organ-item-address"><i class="fas fa-map-marker-alt"></i> {{ $organization->address }}</p>
                        </div>
                        <div class="organ-item-actions">
                            <a href="{{ route('organ.show', $organization) }}" class="organ-action-btn" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('organ.edit', $organization) }}" class="organ-action-btn" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('organ.destroy', $organization) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить эту организацию?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="organ-action-btn organ-action-btn-delete" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pagination-container">
            {{ $organizations->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-building"></i>
            </div>
            <h3>Организации отсутствуют</h3>
            <p>Создайте первую организацию, нажав на кнопку "Добавить организацию"</p>
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
    
    .organ-admin-panel {
        margin-top: 1rem;
    }
    
    .organ-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 0.75rem 1rem;
        background: var(--card-bg);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .organ-count {
        font-weight: 500;
        color: var(--text-secondary);
    }
    
    .organ-admin-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .organ-item {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .organ-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .organ-item-grid {
        display: grid;
        grid-template-columns: 150px 1fr auto;
        gap: 1rem;
    }
    
    @media (max-width: 992px) {
        .organ-item-grid {
            grid-template-columns: 120px 1fr auto;
        }
    }
    
    @media (max-width: 768px) {
        .organ-item-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
        
        .organ-item-actions {
            flex-direction: row !important;
            justify-content: flex-start !important;
            margin-top: 1rem;
        }
    }
    
    .organ-item-image-container {
        height: 100%;
        overflow: hidden;
    }
    
    .organ-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .organ-item-content {
        padding: 1.25rem 0;
    }
    
    .organ-item-title {
        margin: 0 0 0.75rem;
        font-weight: 600;
        font-size: 1.25rem;
    }
    
    .organ-item-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .organ-item-email i,
    .organ-item-phone i {
        margin-right: 0.35rem;
    }
    
    .organ-item-address {
        color: var(--text-secondary);
        margin-bottom: 0;
    }
    
    .organ-item-address i {
        margin-right: 0.35rem;
    }
    
    .organ-item-actions {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0.5rem;
        padding-right: 1.25rem;
    }
    
    .organ-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--bg-color);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .organ-action-btn:hover {
        background: var(--primary-color);
        color: white;
    }
    
    .organ-action-btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
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
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }
    
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
</style>
@endsection
