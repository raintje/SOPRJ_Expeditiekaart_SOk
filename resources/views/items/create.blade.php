<h1>Oops nothing to create yet</h1>

<form method="POST" action="{{route('store.item')}}">
    @csrf
    <input type="text" name="title" id="title">
    <textarea name="body" id="body"></textarea>

    <select multiple class="form-control" id="categories" name="categories">
        @foreach($categories as $category)
            <option value="{{ $category }}">{{ $category }}</option>
        @endforeach
    </select>
    <button type="submit">Submit</button>
</form>
