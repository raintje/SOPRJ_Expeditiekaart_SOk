@extends('layouts.app')

@section('content')
    @foreach($items as $item)
        <p>This is item {{$item->title}}</p>
    @endforeach
@endsection

