<!DOCTYPE html> <!--standard mode for Tiny plugin -->
<!--standard mode for Tiny plugin -->
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- external lib -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<!-- custom -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

<div class="container">
    <h1>Items aanmaken</h1>

    <form method="POST" action="/items" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="title" id="TitelInput" placeholder="Title">
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
            <textarea class="form-control" id="inhoudInput" name="body" rows="15"> </textarea>
        </div>

        <div class="form-group">
            <input type="file" name="files[]" class="file outline--none" multiple>
        </div>

        <button type="submit" class="btn btn-primary"> Opslaan </button>
    </form>
</div>

<script>
    tinymce.init({
      selector: '#inhoudInput',
      language: 'nl'
    });
</script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/item-form.js') }}"></script>