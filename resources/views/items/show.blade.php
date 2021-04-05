@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="float-right">
            <a dusk="edit-button" class="btn btn-outline-secondary" href="{{route('edit.item', $item->id)}}">Aanpassen</a>
            <a class="btn btn-outline-danger" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal">Verwijderen</a>
        </div>
        <h1 class="text-center">{{$item->title}}</h1>

        @if($categories != null)
            <div class="row justify-content-center">
                @foreach($categories as $categorie)
                    <p class="m-3 p-1 border border-dark">{{$categorie->name}}</p>
                @endforeach
            </div>
        @endif

        <div class="m-2">
            {!! $item->body !!}
        </div>

        @if(!$files->isEmpty())
            <div class="m-2">
                <h3>Bijlages:</h3>
                <div class="m-2 row justify-content-start">
                    @foreach($files as $file)
                        <div class="card align-items-center text-center m-2 col-md-3">
                            @if(in_array($file->type, ['jpg','jpeg','png']))
                                <img class="card-img-top mt-1"  src="{{ asset('storage/'.$file->path) }}" alt="Afbeelding kan niet worden geladen" title="{{$file->title}}" >
                            @endif
                            @if(in_array($file->type, ['mp4', 'mpeg']))
                                    <video class="card-img-top mt-1" controls preload="auto" title="{{$file->title}}" >
                                        <source src="{{ asset('storage/'.$file->path) }}" type="video/{{$file->type }}">
                                    </video>
                                @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-break">{{$file->title}}</h5>
                                <a href="{{route('download.file', [$file->id])}}" class="btn btn-info w-100 mt-auto">Download</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @if(!$linkedItems->isEmpty())
        <div class="m-2">
            <h3>Vervolg paden:</h3>
            <div class="m-2 row justify-content-start">
                @foreach($linkedItems as $linkedItem)
                    <div class=" align-items-center text-center mb-2 mt-2 col-md-3">
                        <a class="btn btn-outline-info w-100 h-100" href="{{route('show.item', [$linkedItem->id])}}">{{$linkedItem->title}}</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
