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

    <form method="PUT" action="/items/{{ $item->id }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="title" id="TitelInput" placeholder="Titel" value={{ $item->title }}>
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
            <label for="inhoudInput">Inhoud</label>
            <textarea class="form-control" id="inhoudInput" name="body" rows="15">{{ $item->body }}</textarea>
        </div>

        <div class="form-group">
            <input type="file" name="files[]" class="file outline--none" multiple>
        </div>

        <button type="submit" class="btn btn-primary"> Opslaan </button>
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

