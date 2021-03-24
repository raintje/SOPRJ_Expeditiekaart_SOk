<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<div class="container">
    <h1 class="text-center">{{$item->title}}</h1>

    @if($categories != null)
        <div class="row justify-content-center">
            @foreach($categories as $categorie)
                <p class="m-3 p-1 border border-dark">{{$categorie->name}}</p>
            @endforeach
        </div>
    @endif

    <div class="m-2">
        <?php echo $item->body; ?>
    </div>

    @if($files != null) <!-- TODO check if files is empty not null -->
        <div class="m-2">
            <h3>Bijlages:</h3>
            <div class="row justify-content-start">
                @foreach($files as $file)
                    <div class="card align-items-center text-center m-2 col-md-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$file->title}}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($linkedItems != null) <!-- TODO check if linkeditems is empty not null -->
        <div class="m-2">
            <h3>Vervolg paden:</h3>
            <div class="row justify-content-start">
                @foreach($linkedItems as $linkedItem)
                    <div class="border-left border-info align-items-center text-center m-2 col-md-3">
                        <a class="text-info" href="#">{{$linkedItem->title}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
