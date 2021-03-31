@extends('layouts.app')

@section('content')
    @foreach($items as $item)
        <p>This is item {{$item->title}} - <button type="button" onclick="window.location='{{ route('edit.item', array('id' => $item->id)) }}'" class="btn btn-primary">Item aanpassen</button></p>
    @endforeach
@endsection

