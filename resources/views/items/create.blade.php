<!DOCTYPE html> <!--standard mode for Tiny plugin -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#inhoudInput'
    });
</script>
<div class="container">
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
            <select class="custom-select">
                <option selected>Opties</option>
                @foreach($existingItems as $item)
                    <option value="{{ $item->id }}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inhoudInput">Inhoud</label>
            <textarea class="form-control" id="inhoudInput" name="inhoudInput" rows="15"> </textarea>
        </div>
        <button type="submit" class="btn btn-primary"> Opslaan </button>
    </form>
</div>
