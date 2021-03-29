@extends('layouts.app')

    @section('head_script')
    <script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    @endsection



    @section('content')
    <div class="container">
        <h1>Items aanmaken</h1>
        @if(count($errors) > 0 )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0" style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/items" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="titelInput">Titel</label>
                <input type="text" class="form-control" name="title" id="TitelInput" placeholder="Titel" value="{{old('title','')}}">
            </div>
            <div class="form-group">
                <label> Categorie </label>
                <div class="d-flex">
                    @foreach($categories as $category)
                    <div class="form-check custom-category-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}">
                        <label class="form-check-label" for="category-{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="titelInput">Vervolg pad</label>
                <select id="itemPathSelect" class="custom-select">
                    <option selected>Opties</option>
                    @foreach($existingItems as $item)
                        <option value="{{ $item->id }}">{{$item->title}}</option>
                    @endforeach
                </select>
                <div id="item-links-container">

                </div>
            </div>
            <div class="form-group">
                <label for="inhoudInput">Inhoud</label>
                <textarea class="form-control" id="inhoudInput" name="body" rows="15">{{old('body','')}}</textarea>
            </div>

        <div class="form-group">
            <input id="files" type="file" name="files[]" class="file outline--none" multiple onchange="ValidateSize(this)">
        </div>

            <button type="submit" class="btn btn-primary"> Opslaan </button>
        </form>
    </div>

        @section('script')
        <script>
            tinymce.init({
              selector: '#inhoudInput',
              language: 'nl'
            });

            function ValidateSize(file) {
                let FileSize = file.files[0].size / 1024 / 1024; // in MB
                if (FileSize > 2) {
                    alert('Bestand mag niet groter zijn dan 2MB');
                    $(file).val(''); //for clearing with Jquery
                } else {

                }
            }
        </script>

        <script src="{{ asset('js/item-form.js') }}" defer></script>
        <script src="{{ mix('js/app.js') }}"></script>
        @endsection
@endsection
