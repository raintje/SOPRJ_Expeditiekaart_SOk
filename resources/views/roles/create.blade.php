@extends('layouts.app')
@section('head_script')
    <meta name="csrf" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container-fluid">

        <h2 class="mb-4 text-center">Rol aanmaken <i class="fas fa-info-circle" rel="tooltip" title="{{ __('info.role_create') }}"></i></h2>

        @if(count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0 list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="nameInput">Naam <i class="fas fa-info-circle" rel="tooltip" title="{{ __('info.role_name') }}"></i></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="nameInput" placeholder="Naam" value="{{ old('name', '') }}">
            </div>

            <div class="form-group">
                <label for="titelInput">Bemachtigde items <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.role_items')}}"></i></label>
                <select id="itemPathSelect" class="custom-select">
                    <option selected>Opties</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select>
                <div id="item-links-container">
               
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Rol opslaan</button>

        </form>

    </div>
    <script>
        $(document).ready(function () {
            $("[rel=tooltip]").tooltip();
        });
    </script>
    <script src="{{ asset('js/item-form.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
