@extends('layouts.app')

@section('head_script')
    <script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
@endsection

@section('content')
    <div class="container">
        <h4 class="text-center">Item {{ $item->title }} aanpassen </h4>
        @if (count($errors) > 0)
            <div dusk="error-container" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0" style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('update.item', ['id' => $item->id]) }}" enctype="multipart/form-data">
            @csrf
            {{-- Title --}}
            <div class="form-group">
                <label for="titelInput">Titel <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.title')}}"></i></label>
                <input  type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="titelInput" placeholder="Titel"
                       value="{{ old('title', $item->title) }}">
            </div>

            {{-- Categories --}}
            <div class="form-group">
                <label> Categorie <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.category')}}"></i></label>
                <div class="d-flex flex-column flex-sm-row">
                    @foreach ($categories as $category)
                        <div class="form-check custom-category-check mb-1">
                            <div class="pl-2 pr-2">
                                <input class="form-check-input" type="checkbox" dusk="categories-{{ $category->id }}"
                                       name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                                       @if (!empty($itemcategories))
                                       @if ($itemcategories->contains($category))
                                       checked>
                                @else
                                    > @endif
                                @else
                                    >
                                @endif
                                <label class="form-check-label" for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Selectlist linked items --}}
                <div class="form-group">
                    <label for="itemPathSelect">Vervolgpaden <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.path')}}"></i></label>
                    @if (!empty($linkedItems))
                        <select id="itemPathSelect" class="custom-select mb-2 sm:flex sm:flex-col">
                            <option selected>Opties</option>
                            @foreach ($existingItems as $itemLink)
                                @if (!$linkedItems->contains($itemLink))
                                    <option value="{{ $itemLink->id }}">{{ $itemLink->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                    <div id="item-links-container">
                        @foreach($linkedItems as $linkedItem)
                            <div class="tag">
                                <div class="tag-text">{{ $linkedItem->title }}</div>
                                <div class="tag-close">x</div>
                                <input type="hidden" name="itemLinks[]" value={{ $linkedItem->id }}>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Body --}}
                <div class="form-group ">
                    <label for="inhoudInput">Inhoud <i class="fas fa-info-circle " rel="tooltip" title="{{__('info.body')}}"></i></label>
                    <textarea class="form-control " id="inhoudInput" name="body"
                              rows="15">{{ old('body', $item->body) }}</textarea>
                </div>

                {{-- Linked files --}}
                @if ($files->count() != 0)
                    <div class="m-2">
                        <label for="existing_files">Bijlages: <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.attachments')}}"></i></label>
                        <div id="existing_files" class="m-2 row justify-content-start">
                            @foreach ($files as $file)
                                <div class="card align-items-center text-center m-2 col-md-3">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-break">{{ $file->title }}</h5>
                                        <a href="{{route('delete.file', ['id' => $item->id, 'fileId' => $file->id])}}" class="btn btn-primary w-100 mt-auto">Verwijderen</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Upload files --}}
                <div class="form-group">
                    <label for="files[]">Bestanden <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.files')}}"></i></label>
                    <input type="file" name="files[]" class="file outline--none form-control-file" multiple>
                </div>

                {{-- Form submit --}}
                <button type="submit" class="btn btn-primary mb-1"> Wijzigingen opslaan</button>

        </form>
    </div>
@endsection

@section('script')
    <script>
        tinymce.init({
            selector: '#inhoudInput',
            language: 'nl',
            plugins: 'link',
        });

        function ValidateSize(file) {
            let FileSize = file.files[0].size / 1024 / 1024; // in MB
            if (FileSize > 2) {
                alert('Bestand mag niet groter zijn dan 2MB');
                $(file).val(''); //for clearing with Jquery
            } else {

            }
        }

        $(document).ready(function(){
            $("[rel=tooltip]").tooltip();
        });

    </script>
    <script src="{{ asset('js/item-form.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
