<!DOCTYPE html>
<!--standard mode for Tiny plugin -->
<!--standard mode for Tiny plugin -->
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- external lib -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- custom -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}" />

<div class="container">
    <h1>Item {{ $item->title }} aanpassen </h1>
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

    <form method="POST" action="/items/{{ $item->id }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="title" id="TitelInput" placeholder="Titel" value="{{ $item->title }}">
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
            <textarea class="form-control" id="inhoudInput" name="body" rows="15">{{ $item->body }}</textarea>
        </div>

        @if(!empty($files))
        <div class="m-2">
            <h3>Bijlages:</h3>
            <div class="m-2 row justify-content-start">
                @foreach($files as $file)
                <div class="card align-items-center text-center m-2 col-md-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $file->title }}</h5>
                        <a href="#" class="btn btn-primary w-100 mt-auto">Verwijderen</a>
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
                        <a href="#" class="btn btn-primary w-100 mt-auto">Verwijderen</a>
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
    </form>
</div>

<script>
    tinymce.init({
        selector: '#inhoudInput'
        , language: 'nl'
    });

</script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/item-form.js') }}"></script>
