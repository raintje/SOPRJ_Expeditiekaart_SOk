@extends('layouts.app')
@section('head_script')
    <meta name="csrf" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container-fluid">

        <h2 class="mb-4 text-center">Gebruiker aanmaken<i class="fas fa-info-circle" rel="tooltip"
                                                          title="{{ __('info.user_create') }}"></i></h2>

        @if(count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0 list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="nameInput">Naam <i class="fas fa-info-circle" rel="tooltip"
                                               title="{{ __('info.name') }}"></i></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="nameInput"
                       placeholder="Naam" value="{{ old('name','') }}">
            </div>

            <div class="form-group">
                <label for="emailInput">Emailadres <i class="fas fa-info-circle" rel="tooltip"
                                                      title="{{ __('info.email') }}"></i></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       id="emailInput"
                       placeholder="Emailadres" value="{{ old('email','') }}">
            </div>

            <button type="submit" class="btn btn-primary">Gebruiker aanmaken</button>

        </form>

    </div>
    <script>
        $(document).ready(function () {
            $("[rel=tooltip]").tooltip();
        });
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
