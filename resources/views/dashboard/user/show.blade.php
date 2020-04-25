@extends('dashboard.master')

@section('content')

<div class="form-group">
    <label for="name">Nombre</label>
    <input readonly type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
</div>
<div class="form-group">
    <label for="surname">Apellidos</label>
    <input readonly type="text" class="form-control" name="surname" id="surname" value="{{ $user->surname }}">
</div>


@endsection