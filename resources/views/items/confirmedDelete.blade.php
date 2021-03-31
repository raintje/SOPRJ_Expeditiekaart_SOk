@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Het item is met succes verwijderd!</h3>
        <a href="{{route('home')}}" class="btn btn-primary">Terug naar de expeditiekaart</a>
    </div>
@endsection
