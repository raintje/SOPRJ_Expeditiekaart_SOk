@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <h1>Gebruiker toevoegen</h1>
    @if(count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0" style="list-style: none;">
                @foreach($errors->all as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('store.user') }}" enctype="multipart/form-data">
    @csrf
    
    </form>

</div>
@endsection
