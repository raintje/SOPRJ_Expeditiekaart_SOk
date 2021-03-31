@extends('items.show')

@section('alert')
    <div class="alert alert-danger fade show" role="alert">
        <div class="align-self-start">
            <strong>Let op!</strong>
            <p>Weet je zeker dat je dit item wilt vewijderen?</p>
            <strong>Dit kan <u>niet</u> ongedaan gemaakt worden!</strong>
        </div>
        <div class="align-self-end mt-2">
            <a class="btn btn-danger" href="{{route('destroy.item', $item->id)}}">Verwijderen</a>
            <a class="btn btn-primary" href="{{route('show.item', $item->id)}}">Annuleren</a>
        </div>
    </div>
@endsection
