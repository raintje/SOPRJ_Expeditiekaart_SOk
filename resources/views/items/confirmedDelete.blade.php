@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Het item is succesvol verwijderd!</h3>
        <a href="{{route('home')}}" class="btn btn-primary">Terug naar de expeditiekaart</a>
    </div>
@endsection
