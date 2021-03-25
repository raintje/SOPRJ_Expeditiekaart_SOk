@foreach($items as $item)
    <p>This is item {{$item->title}} - <a href="{{ url('/items/' . $item->id . '/edit') }}" class="btn btn-primary mt-auto">Aanpassen</a></p>
@endforeach

