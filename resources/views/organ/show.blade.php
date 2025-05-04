@extends('layouts.app')

@section('title', 'Просмотр организации')

@section('content')
<div class="section-header">
    <h2 class="section-title">Просмотр организации</h2>
    <div class="header-actions">
        <a href="{{ route('organ.edit', $organ) }}" class="btn-primary">
            <i class="fas fa-edit"></i> Редактировать
        </a>
        <a href="{{ route('organ.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> К списку организаций
        </a>
    </div>
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

<div class="organ-detail-container">
    <div class="organ-detail-card">
        <div class="organ-detail-header">
            <div class="organ-logo-wrapper">
                <img src="{{ asset($organ->logo) }}" alt="{{ $organ->name }}" class="organ-logo">
            </div>
            <div class="organ-title-wrapper">
                <h1 class="organ-title">{{ $organ->name }}</h1>
                <div class="organ-meta">
                    <span class="organ-id">ID: {{ $organ->id }}</span>
                    <span class="organ-created">Создано: {{ $organ->created_at->format('d.m.Y H:i:s') }}</span>
                </div>
            </div>
        </div>
        
        <div class="organ-detail-body">
            <div class="organ-info-section">
                <h3 class="info-section-title">Контактная информация</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-envelope"></i> Email:</div>
                        <div class="info-value">{{ $organ->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-phone"></i> Телефон:</div>
                        <div class="info-value">{{ $organ->phone }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-map-marker-alt"></i> Адрес:</div>
                        <div class="info-value">{{ $organ->address }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-clock"></i> Последнее обновление:</div>
                        <div class="info-value">{{ $organ->updated_at->format('d.m.Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="organ-detail-footer">
            <form action="{{ route('organ.destroy', $organ) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту организацию?');" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i> Удалить организацию
                </button>
            </form>
        </div>
    </div>
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
    
    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1.2rem;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    
    .btn-primary i, .btn-secondary i, .btn-danger i {
        margin-right: 0.5rem;
    }
    
    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
    }
    
    .alert i {
        margin-right: 0.5rem;
        font-size: 1.25rem;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    
    .organ-detail-container {
        margin-top: 1.5rem;
    }
    
    .organ-detail-card {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .organ-detail-header {
        display: flex;
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
        background: rgba(var(--primary-color-rgb), 0.05);
    }
    
    .organ-logo-wrapper {
        flex: 0 0 200px;
        margin-right: 2rem;
    }
    
    .organ-logo {
        width: 100%;
        height: auto;
        max-height: 200px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .organ-title-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .organ-title {
        margin: 0 0 0.5rem;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .organ-meta {
        display: flex;
        gap: 1rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .organ-detail-body {
        padding: 2rem;
    }
    
    .organ-info-section {
        margin-bottom: 2rem;
    }
    
    .info-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    
    .info-label i {
        margin-right: 0.5rem;
        width: 20px;
        text-align: center;
    }
    
    .info-value {
        font-size: 1.1rem;
    }
    
    .organ-detail-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-color);
        display: flex;
        justify-content: flex-end;
    }
    
    @media (max-width: 768px) {
        .organ-detail-header {
            flex-direction: column;
        }
        
        .organ-logo-wrapper {
            margin-right: 0;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .organ-logo {
            max-width: 200px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
