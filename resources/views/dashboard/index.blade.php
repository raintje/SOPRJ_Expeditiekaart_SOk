@extends('layouts.app')

@section('head_script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="pb-3">
        <h2 class="mb-4">Dashboard</h2>
        <p class="font-weight-bold">Snelle toegang</p>
        <hr>
        <div class="float-left">
            <a href="{{ route('users.index') }}"><button class="btn btn-primary"><i class="fa fa-user"></i>
                    Gebruikersoverzicht</button></a>
            <a href="{{ route('items') }}"><button class="btn btn-primary"><i class="fa fa-list"></i>
                    Itemoverzicht</button></a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md p-2 w-100">
            <p class="font-weight-bold">Nieuws</p>
            <hr>
            @foreach ($itemHistories as $history)
                <div style="width: max-content" class="overflow-auto">
                    <p>
                        <b>{{ $history->performed_at->format('d-m-Y H:i') }}</b> -
                        @if ($history->message == 'Updating LayerItem ')
                            @if ($history->model() != null)
                                {{ $history->model()->title }} is aangepast door
                                {{ $history->user()->getRoleNames()->first() }} {{ $history->user()->name }}
                    </p>
                @else
                    Item {{ $history->model_id }} is aangemaakt door {{ $history->user()->getRoleNames()->first() }}
                    {{ $history->user()->name }}</p>
            @endif
        @elseif($history->message == 'Deleting LayerItem ')
            Item {{ $history->model_id }} is verwijderd door {{ $history->user()->getRoleNames()->first() }}
            {{ $history->user()->name }}</p>
            @endif
            <hr>
        </div>
        @endforeach

    </div>
    <div class="col-md p-2 w-100">
        <p class="font-weight-bold">Gebruiksgegevens</p>
        <hr>
    </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>

@endsection
