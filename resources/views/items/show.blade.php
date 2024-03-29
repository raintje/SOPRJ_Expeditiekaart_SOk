@extends('layouts.app')

@section('title', $item->title)

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Let op!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Weet je zeker dat je dit item wilt vewijderen?</p>
                    <strong>Dit kan <u>niet</u> ongedaan gemaakt worden!</strong>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" dusk="modal-delete-button" href="{{route('destroy.item', $item->id)}}">Verwijderen</a>
                    <a class="btn btn-outline-secondary" href="javascript:void(0)" data-dismiss="modal"
                       aria-label="Close">Annuleren</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

    {{ Breadcrumbs::render('items', $breadcrumb) }}

        @auth
            @can('layerItem.edit.'.$item->id)
                <div class="float-right">
                    <a dusk="edit-button" class="btn btn-outline-secondary"
                       href="{{route('edit.item', $item->id)}}">Aanpassen</a>
                    <a dusk="delete-button" class="btn btn-outline-danger" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal">Verwijderen</a>
                </div>
            @endcan
        @endauth
        <h1 class="text-center" id="item--title">{{$item->title}}</h1>

        <div class="m-2" id="item--body">
            {!! $item->body !!}
        </div>

        @if(!$files->isEmpty())
            <div class="m-2">
                <h3>Bijlages:</h3>
                <div class="m-2 row justify-content-start">
                    @foreach($files as $file)
                        <div class="card align-items-center text-center m-2 col-md-3">
                            @if(in_array($file->type, ['jpg','jpeg','png']))
                                <img class="card-img-top mt-1" src="{{ asset('storage/'.$file->path) }}"
                                     alt="Afbeelding kan niet worden geladen" title="{{$file->title}}">
                            @endif
                            @if(in_array($file->type, ['mp4', 'mpeg']))
                                <video class="card-img-top mt-1" controls preload="auto" title="{{$file->title}}">
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
                        <a dusk="link-button" class="btn btn-outline-info w-100 h-100" href="{{route('breadcrumb.add', ['id' => $linkedItem->id, 'breadcrumb' => $breadcrumb])}}">{{$linkedItem->title}}</a>
                    </div>
                @endforeach
            </div>
        @endif


        @if(!$histories->isEmpty())

            <p>
                <button class="btn btn-info w-100 mt-auto" type="button" id="showHistory">
                    Voorgaande aanpassingen weergeven
                </button>
            </p>


                <div class="row">
                    <div class="col-md" id="collapseHistory">
                        <h4>Voorgaande aanpassingen</h4>
                        <ul class="timeline">
                            @foreach($histories as $history)
                                @foreach($history->meta as $historyData)
                                    <li class="shadow ml-3 history--item">
                                        <div class="row">
                                            <div class="col-md-11 p-3">
                                                <a href="#">{{$historyData['key']}}</a>
                                                <a href="#"
                                                   class="ml-5">{{date('d-m-Y', strtotime($history->performed_at))}}</a>
                                                @if($historyData['key'] == 'body')
                                                    <p>{!! $historyData['old']!!}</p>
                                                @else
                                                    <p>{{$historyData['old']}}</p>
                                                @endif

                                            </div>

                                            @auth
                                                @can('layerItem.edit.'.$item->id)
                                                    <div class="col-md-1">

                                                        <div class="management--container">
                                                            <div class="content">
                                                                <a href="{{route('restore.item', $history->id)}}">
                                                                    <div class="icon icon-expand" id="res--itemhistory" data-toggle="tooltip" data-placement="right" title="Terugzetten"><i class="fa fa-edit"></i>
                                                                    </div>
                                                                </a>
                                                                <a href="{{route('destroy.itemHistory', $history->id)}}">
                                                                    <div class="icon icon-expand" id="del--itemhistory" data-toggle="tooltip" data-placement="right" title="Verwijderen"><i class="fa fa-trash"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan
                                            @endauth
                                        </div>
                                    </li>

                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $("#collapseHistory").hide();
            $('#showHistory').click(function () {
                $('#collapseHistory').toggle('slow');
            });
        });

        $(document).ready(function(){
            $("[rel=tooltip]").tooltip();
        });
    </script>

    <script src="{{ mix('js/app.js') }}"></script>
@endsection
