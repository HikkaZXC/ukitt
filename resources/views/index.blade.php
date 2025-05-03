@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container">
        <div class="news-list py-2">
            @foreach ($posts as $post)
                <div class="news-item">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="news-item-image">
                                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="news-item-content">
                                <h3 class="news-item-title">{{ $post->title }}</h3>
                                <div class="news-item-meta">
                                    <span class="news-item-author">
                                        <i class="fas fa-user"></i> {{ $post->user->name }}
                                    </span>
                                    <span class="news-item-date">
                                        <i class="far fa-calendar-alt"></i> {{ $post->created_at->format('d.m.Y') }}
                                    </span>
                                </div>
                                <p class="news-item-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}</p>
                                <a href="{{ route('post.show', $post) }}" class="btn-read-more">Читать далее <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($posts->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Нет доступных новостей</h3>
                <p>На данный момент новости отсутствуют. Пожалуйста, загляните позже.</p>
            </div>
        @endif
    </div>
@endsection
