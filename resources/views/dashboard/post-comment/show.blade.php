@extends('dashboard.master')

@section('content')

<div class="form-group">
    <label for="title">Título</label>
    <input readonly type="text" class="form-control" value="{{ $postComment->title }}">
</div>
<div class="form-group">
    <label for="user">Usuario</label>
    <input readonly type="text" class="form-control" value="{{ $postComment->user->name }}">
</div>
<div class="form-group">
    <label for="approved">Aprobado</label>
    <input readonly type="text" class="form-control" value="{{ $postComment->approved }}">
</div>
<div class="form-group">
    <label for="content">Mensaje</label>
    <textarea readonly class="form-control" rows="3">{{ $postComment->message }}</textarea>
</div>


@endsection