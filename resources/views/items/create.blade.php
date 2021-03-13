<!DOCTYPE html> <!--standard mode for Tiny plugin -->
<!--standard mode for Tiny plugin -->
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- external lib -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- the main fileinput plugin file -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/locales/nl.js"></script>

<link rel="stylesheet" href="/css/item-form.css"/>
<script src="/js/item-form.js"></script>

<div class="container">
    <h1>Items aanmaken</h1>

    <form method="POST" action="/items">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="name" id="TitelInput" placeholder="Title">
        </div>
        <div class="form-group">
            <label> Categorie </label>
            <div class="item-row">
                @foreach($categories as $category)
                <div class="form-check custom-category-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category }}" id="category-{{ $category }}">
                    <label class="form-check-label" for="category-{{ $category }}">
                        {{ $category }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label for="titelInput">Vervolg pad</label>
            <select onchange="AddItemPath(this, 'item-links-container')" class="custom-select">
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
            <textarea class="form-control" id="inhoudInput" name="inhoudInput" rows="15"> </textarea>
        </div>

        <div class="form-group">
            <input id="input-krajee" type="file" name="files" class="file" data-preview-file-type="text" >
        </div>

        <button type="submit" class="btn btn-primary"> Opslaan </button>
    </form>
</div>

<script>
    tinymce.init({
      selector: '#inhoudInput',
      language: 'nl'
    });

    $("#input-krajee").fileinput({
        theme: "fas",
        uploadUrl: "/items",
        language: "nl"
    });

    $('option').mousedown(function(e) {
        e.preventDefault();
        $(this).prop('selected', !$(this).prop('selected'));
        return false;
    });
</script>