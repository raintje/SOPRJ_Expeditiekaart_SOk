
<div class="">
    <h1>Items aanmaken</h1>

    <form method="POST" action="/items">
        @csrf
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="name" id="TitelInput" placeholder="Title">
        </div>
        <div class="form-group">
            <label> Categorie </label>
            <div class="row">
                <div class="form-check">
                    <label for="categories">Categorie(n)</label>
                    <select multiple class="form-control" id="categories" name="category">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="titelInput">Vervolg pad</label>
            <select class="custom-select">
                <option selected>Opties</option>
                @foreach($existingItems as $item)
                    <option value="{{ $item->id }}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inhoudInput">Inhoud</label>
            <textarea class="form-control" id="inhoudInput" rows="15"> </textarea>
        </div>
        <button type="submit"> Opslaan </button>
    </form>
</div>
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#inhoud'
    });
</script>