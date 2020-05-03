@extends('dashboard.master')

@section('content')

<a class="btn btn-success btn-block mt-3 mb-3" href="{{ route('post.create')}}">
    <i class="fa fa-plus"></i> Crear
</a>

<form action="{{ route("post.index") }}" method="GET" class="form-inline mb-2">
    <select name="created_at" id="" class="form-control">
        <option value="DESC">Descendente</option>
        <option {{ request('created_at') == "ASC" ? "selected" : ""}}
        value="ASC">Ascendente</option>
    </select>
<input type="text" value="{{ request('search') }}" name="search" placeholder="Buscar..." class="form-control ml-2">
    <button class="btn btn-success ml-2" type="submit"> <i class="fa fa-search"></i></button>
</form>

<table class="table">
    <thead>
        <tr>
            <td>
                ID
            </td>
            <td>
                Título
            </td>
            <td>
                Categoría
            </td>
            <td>
                Posteado
            </td>
            <td>
                Creación
            </td>
            <td>
                Actualización
            </td>
            <td>
                Acciones
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>
                {{ $post->id }}
            </td>
            <td>
                {{ $post->title }}
            </td>
            <td>
                {{ $post->category->title}}
            </td>
            <td>
                {{ $post->posted}}
            </td>
            <td>
                {{ $post->created_at->format('d-m-Y') }}
            </td>
            <td>
                {{ $post->updated_at->format('d-m-Y') }}
            </td>
            <td>
                <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                @if (count($post->comments) > 0)
                <a href="{{ route('post-comment.post', $post->id) }}" class="btn btn-primary"><i class="fa fa-comment"></i></a>
                @endif

                <button data-toggle="modal" data-target="#deleteModal" data-id="{{ $post->id }}"
                    class="btn btn-danger"><i class="fa fa-trash"></i></button>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $posts->appends(
    [
        'created_at' => request('created_at'),
        'search' => request('search')
    ])->links() }}

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que quieres borrar este post?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <form id="formDelete" action="{{ route('post.destroy', 0) }}"
                    data-action="{{ route('post.destroy', 0) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
    $('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

  action = $('#formDelete').attr('data-action').slice(0, -1);

  console.log(action+id);

  $('#formDelete').attr('action', action + id)

  var modal = $(this)
  modal.find('.modal-title').text('Eliminar post: ' + id)
})
    }
</script>

@endsection