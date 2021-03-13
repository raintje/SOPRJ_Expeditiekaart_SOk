<!DOCTYPE html> <!--standard mode for Tiny plugin -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="/js/item-form.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/item-form.css"/>
<script>
    tinymce.init({
      selector: '#inhoudInput'
    });
</script>
<div class="container">.
    <h1>Items aanmaken</h1>

    <form method="POST" action="/items">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="name" id="TitelInput" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="categories">Categorie(n)</label>
            <select multiple class="form-control" id="categories" name="categories">
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
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

        <div class="custom-file">
            <input id="input-id" type="file" class="file" data-preview-file-type="text" >
        </div>

        <button type="submit" class="btn btn-primary"> Opslaan </button>
    </form>
</div>
