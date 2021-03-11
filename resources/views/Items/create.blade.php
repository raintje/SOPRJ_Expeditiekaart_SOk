
<div class="">
    <h1>Items aanmaken</h1>

    <form>
        <div class="form-group">
            <label for="titelInput">Titel</label>
            <input type="text" class="form-control" id="TitelInput" placeholder="Title">
        </div>
        <div class="form-group">
            <label> Categorie </label>
            <div class="row">
                @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="category-{{ $category }}">
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
                @foreach($categories as $category)
                    <option value="2">Two</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
