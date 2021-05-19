@unless ($breadcrumbs->isEmpty())
    <ol class="breadcrumb bg-white" dusk="breadcrumb-list">
        <i class="fas fa-info-circle line-height-default mr-2" rel="tooltip" title="{{__('info.breadcrumb')}}"></i>   
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><em><a class="text-info" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></em></li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>

@endunless