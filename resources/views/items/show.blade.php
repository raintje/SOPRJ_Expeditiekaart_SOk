<h1>{{$item->title}}</h1>
<h3>Categories:</h3>
@if($categories != null)
    @foreach($categories as $categorie)
        <p>{{$categorie->name}}</p>
    @endforeach
@endif
<h3>Files:</h3>
@if($files != null)
    @foreach($files as $file)
        <p>{{$file->title}}</p>
    @endforeach
@endif
<h3>Linked Items:</h3>
@if($linkedItems != null)
    @foreach($linkedItems as $linkedItem)
        <p>{{$linkedItem->title}}</p>
    @endforeach
@endif
