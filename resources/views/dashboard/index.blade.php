@extends('layouts.app')

@section('head_script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="pb-3">
        <h2 class="mb-4">Dashboard</h2>
    </div>
    <p class="font-weight-bold">Snelle toegang</p>
    <hr>
    <a href="{{route('users.index')}}"><button class="btn btn-primary">Gebruikers overzicht</button></a>
    <a href="{{route('items')}}"><button class="btn btn-primary">Item overzicht</button></a>

    <div class="row mt-5">
        <div class="col-md p-2 w-100">
            <p class="font-weight-bold">Nieuws</p>
            <hr>
            @foreach($itemHistories as $history)
                <div>
                @if($history->message == 'Updating LayerItem ')
                <p>item {{$history->model_id}} is aangepast door gebruiker {{$history->user_id}}</p>
                @elseif($history->message == 'Deleting LayerItem ')
                    <p>item {{$history->model_id}} is verwijderd door gebruiker {{$history->user_id}}</p>
                @endif
                </div>
            @endforeach

        </div>
        <div class="col-md p-2 w-100">
            <p class="font-weight-bold">gebruiksgegevens</p>
            <hr>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>

@endsection
