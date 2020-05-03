@extends('dashboard.master')

@section('content')
<div class="col-6 mb-3">
    <form action="{{ route('post-comment.post', 1) }}" id="filterForm">
        <div class="form-row">
            <div class="col-10">
                <select name="" id="filterPost" class="form-control">
                    @foreach ($posts as $p)
                    <option value="{{ $p->id }}" {{ $postSelected->id == $p->id ? 'selected' : ''}}>
                        {{ Str::limit($p->title, 50) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <button class="btn btn-success" type="submit">Enviar</button>
            </div>
        </div>
    </form>
</div>

@if (count($postComments) > 0)

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
                Aprobado
            </td>
            <td>
                Usuario
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
        @foreach ($postComments as $postComment)
        <tr>
            <td>
                {{ $postComment->id }}
            </td>
            <td>
                {{ $postComment->title }}
            </td>
            <td>
                {{ $postComment->approved}}
            </td>
            <td>
                {{ $postComment->user->name}}
            </td>
            <td>
                {{ $postComment->created_at->format('d-m-Y') }}
            </td>
            <td>
                {{ $postComment->updated_at->format('d-m-Y') }}
            </td>
            <td>
                <button data-toggle="modal" data-target="#showModal" data-id="{{ $postComment->id }}"
                    class="btn btn-primary">Ver</button>

                <button data-id="{{ $postComment->id }}"
                    class="approved btn {{ $postComment->approved == 1 ? "btn-success" : "btn-secondary"}}">{{ $postComment->approved == 1 ? "Aprobado" : "Rechazado"}}</button>

                <button data-toggle="modal" data-target="#deleteModal" data-id="{{ $postComment->id }}"
                    class="btn btn-danger">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $postComments->links() }}

<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <p class="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


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
                <p>¿Seguro que quieres borrar este comentario?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <form id="formDelete" action="{{ route('post-comment.destroy', 0) }}"
                    data-action="{{ route('post-comment.destroy', 0) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>

            </div>
        </div>
    </div>
</div>

@else

<h1>No existen comentarios en este post.</h1>

@endif

<script>
    document.querySelectorAll(".approved").forEach(button => button.addEventListener("click", 
        function(){

        var id = button.getAttribute("data-id")

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

            // $.ajax({
            //     method: "POST",
            //     url: "{{ URL::to("/") }}/dashboard/post-comment/process/" + id,
            //     data: { '_token': '{{ csrf_token() }}'}
            // })
            // .done(function( approved ) {
            //     if(approved == '1'){
            //         $(button).removeClass('btn-secondary');
            //         $(button).addClass('btn-success');
            //         $(button).text('Aprobado');
            //     } else {
            //         $(button).removeClass('btn-success');
            //         $(button).addClass('btn-secondary');
            //         $(button).text('Rechazado');
            //     }
            // });

            fetch("{{ URL::to("/") }}/dashboard/post-comment/process/" + id, {
                method: "POST",
                body: formData
            })
                .then(resp => resp.json())
                .then(approved => {
                    if(approved == '1'){
                        button.classList.remove('btn-secondary');
                        button.classList.add('btn-success')
                        button.innerHTML = "Aprobado"
                    } else {
                        button.classList.remove('btn-success');
                        button.classList.add('btn-secondary')
                        button.innerHTML = "Rechazado"
                    }
                    
            });
        })
    );

    

    window.onload = function(){

        $("#filterForm").submit(function(){
            var action = $(this).attr('action');
            action = action.replace(/[0-9]/g ,$("#filterPost").val());
            $(this).attr('action', action)
        });

        $('#deleteModal').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
 
            action = $('#formDelete').attr('data-action').slice(0, -1);

            $('#formDelete').attr('action', action + id)

            var modal = $(this)
            modal.find('.modal-title').text('Eliminar comentario: ' + id)

        });

        $('#showModal').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)

            // $.ajax({
            //     method: "GET",
            //     url: "{{ URL::to("/") }}/dashboard/post-comment/j-show/" + id,
            //     //data: { name: "John", location: "Boston" }
            //     })
            //     .done(function( msg ) {
            //         modal.find('.modal-title').text(msg.title)
            //         modal.find('.message').text(msg.message)
            //     });

            fetch("{{ URL::to("/") }}/dashboard/post-comment/j-show/" + id)
                .then(resp => resp.json())
                .then(comment => {
                    modal.find('.modal-title').text(comment.title)
                    modal.find('.message').text(comment.message)
            });

        });

    }

</script>

@endsection