@extends('layouts.app')

@section('content')
    <h1>Item {{ $item->title }} aanpassen </h1>
    @if($errors->any() )
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

    <form method="POST" action="/items/{{ $item->id }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="title" id="TitelInput" placeholder="Titel" value="{{old('title',$item->title)}}">
        </div>
        <div class="form-group">
            <label> Categorie </label>
            <div class="d-flex">
                @foreach($categories as $category)
                <div class="form-check custom-category-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                    @if(!empty($itemcategories))
                        @if($itemcategories->contains($category))
                            checked>
                        @else
                            >
                        @endif
                    @else
                        >
                    @endif
                    <label class="form-check-label" for="category-{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label for="inhoudInput">Inhoud</label>
            <textarea class="form-control" id="inhoudInput" name="body" rows="15">{{ old('body', $item->body) }}</textarea>
        </div>

        @if(!empty($files))
        <div class="m-2">
            <h3>Bijlages:</h3>
            <div class="m-2 row justify-content-start">
                @foreach($files as $file)
                <div class="card align-items-center text-center m-2 col-md-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $file->title }}</h5>
                        <a href="{{route('delete.file',['id' => $item->id, 'fileId' => $file->id])}}" class="btn btn-primary w-100 mt-auto">Verwijderen</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="form-group">
            <input type="file" name="files[]" class="file outline--none" multiple>
        </div>

        @if(!empty($linkedItems))
        <div class="m-2">
            <h3>Vervolg paden:</h3>
            <div class="m-2 row justify-content-start">
                @foreach ($linkedItems as $linkedItem)
                <div class="card align-items-center text-center m-2 col-md-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $linkedItem->id }}: {{ $linkedItem->title }}</h5>
                        <a href="{{route('delete.linkedFile',['id' => $item->id, 'linkId' => $linkedItem->id ])}}" class="btn btn-primary w-100 mt-auto">Verwijderen</a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <select id="itemPathSelect" class="custom-select mb-2">
                <option selected>Opties</option>
                @foreach($existingItems as $item)
                @if(!$linkedItems->contains($item))
                <option value="{{ $item->id }}">{{$item->title}}</option>
                @endif
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary"> Wijzigingen opslaan </button>
        </div>
    </form>
    @endsection

