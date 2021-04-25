@extends('layouts.app')

@section('content')

    <div class="pb-3">
        <h2 class="mb-4">Dashboard</h2>
    </div>
    <p class="font-weight-bold">Snelle toegang</p>
    <hr>
    <a href="{{route('users')}}"><button class="btn btn-primary">Gebruikers overzicht</button></a>
    <a href="{{route('items')}}"><button class="btn btn-primary">Item overzicht</button></a>

@endsection
