@if(isset($breadcrumbs))
    <nav aria-label="breadcrumb">
        <div class="breadcrumb">
            <ol class="breadcrumb-items">
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
    </nav>
@endif 