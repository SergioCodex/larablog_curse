@extends('dashboard.master')

@section('content')

<div class="form-group">
    <label for="name">Nombre</label>
    <input readonly type="text" class="form-control" value="{{ $contact->name }}">
</div>
<div class="form-group">
    <label for="surname">Apellido</label>
    <input readonly type="text" class="form-control" name="surname" id="surname" value="{{ $contact->surname }}">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input readonly type="text" class="form-control" name="email" id="email" value="{{ $contact->email }}">
</div>
<div class="form-group">
    <label for="content">Contenido</label>
    <textarea readonly class="form-control" rows="3">{{ $contact->message }}</textarea>
</div>


@endsection