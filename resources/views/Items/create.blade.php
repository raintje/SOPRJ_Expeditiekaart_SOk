
<div class="">
    <h1>Items aanmaken</h1>

    <form>
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" name="name" id="TitelInput" placeholder="Title">
        </div>
        <div class="form-group">
            <label> Categorie </label>
            <div class="row">
                @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category-{{ $category }}" id="category-{{ $category }}">
                    <label class="form-check-label" for="category-{{ $category }}">
                        {{ $category }}
                    </label>
                </div>
                @endforeach
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
            <label for="inhoudInput">Inhoudelijke informatie</label>
            <textarea class="form-control" id="inhoudInput" rows="15"> </textarea>
        </div>
    </form>
</div>
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#inhoudi'
    });
</script>