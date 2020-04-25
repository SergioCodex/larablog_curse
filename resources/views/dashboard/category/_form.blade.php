@csrf
<div class="form-group">
    <label for="title">Título</label>
    <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $category->title  ?? '') }}">

    <!--@error('title')
        <small class="text-danger">{{ $message}}</small>
        @enderror-->

</div>
<div class="form-group">
    <label for="url_clean">Url limpia</label>
    <input type="text" class="form-control" name="url_clean" id="url_clean" value="{{ old('url_clean', $category->url_clean  ?? '') }}">
</div>
<input type="submit" class="btn btn-primary" value="Enviar"></button>