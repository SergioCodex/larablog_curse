@extends('dashboard.master')

@section('content')

<div class="form-group">
    <label for="title">Título</label>
    <input readonly type="text" class="form-control" name="title" id="title" value="{{ $category->title }}">
</div>
<div class="form-group">
    <label for="url_clean">Url limpia</label>
    <input readonly type="text" class="form-control" name="url_clean" id="url_clean" value="{{ $category->url_clean }}">
</div>


@endsection