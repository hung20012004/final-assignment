@props(['links'])

<nav aria-label="breadcrumb" class="">
    <ol class="breadcrumb bg-light mx-4">
        @foreach ($links as $link)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $link['label'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
