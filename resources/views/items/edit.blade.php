<!DOCTYPE html>
<!--standard mode for Tiny plugin -->
<!--standard mode for Tiny plugin -->
<script src="https://cdn.tiny.cloud/1/2t1jg49md5wferhnxq0lnsjm72c9ghml73cho300vr1sgv9w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- external lib -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- custom -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}" />

<h1>Aanpassen van item {{ $item->title }}</h1>

{{--<!-- Display errors -->--}}
{{--<div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--        <span aria-hidden="true">&times;</span>--}}
{{--    </button>--}}
{{--    {{ Html::ul($errors->all()) }}--}}
{{--</div>--}}

{{ Form::model($item, array('route' => array('edit.item', $item->id), 'method' => 'PUT')) }}

<div class="form-group">
    {{ Form::label('title', 'Titel') }}
    {{ Form::text('title', $item->title, array('class'=>'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('category', 'Categorie') }}
    <div class="d-flex">
        @foreach($categories as $category)
            @if($category->id == $item->category->id)
            {{ Form::checkbox('category', $category->id, true, array('class' => 'form-check-input')) }}
            {{ Form::label('category', $category->name, array('class' => 'form-check-label', 'for' => $category->id)) }}
            @else
            {{ Form::checkbox('category', $category->id, false, array('class' => 'form-check-input')) }}
            @endif
        @endforeach
    </div>

</div>

<div class="form-group">
    {{ Form::label('body', 'Beschrijving') }}
    {{ Form::text('title') }}
</div>

{{ Form::submit('Wijzigingen opslaan', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

<script>
    tinymce.init({
        selector: '#inhoudInput'
        , language: 'nl'
    });

</script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/item-form.js') }}"></script>

