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

    <script src="{{ mix('js/app.js') }}"></script>

@endsection
