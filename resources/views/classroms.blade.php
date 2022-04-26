@extends('layouts.app')
@section('title', 'Salones y Clases')
@section('content')
    <style>
        a 
        {
            text-decoration: none;
            color: black;
        }

    </style>
    <div class="container">
        <div class="row justify-content-center">
            @auth
                <div class="col-2 d-flex flex-column">
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                        data-bs-target="#addClassrom">Agregar Salon de clases</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">Agregar
                        Clase</button>
                </div>
                <div class="container col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col flex-column">
                                    <h4>Salones</h4>
                                    <p class="text-muted">Da click para ver el salon</p>
                                    @foreach ($classr as $c)
                                        <a href="/salon/{{ $c->id }}"><button type="button" class="btn btn-light">{{ $c->classrom }}</button></a>
                                    @endforeach
                                </div>
                                <div class="col flex-colums">
                                    <h4>Clases</h4>
                                    <p class="text-muted">Da click para editar la clase o eliminarla</p>
                                    @foreach ($lessons as $l)
                                        <button type="button" class="btn btn-light" id='lesson-{{ $l->id }}'
                                            data-bs-toggle="modal" data-bs-target="#editLesson">{{ $l->name }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Modal add classrom-->
    <div class="modal fade" id="addClassrom" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Salon de Clases</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="get">
                        @csrf
                        <div class="modal-body">
                            <label for="#id">Salon</label>
                            <input type="text" class="form-control" id="id" name="classrom" value="" required>
                        </div>
                        <input type="hidden" name="action" value="1">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button submit" class="btn btn-primary">Guardar Salon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add lesson-->
    <div class="modal fade" id="addLesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Clase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="get">
                        @csrf
                        <div class="modal-body">
                            <label for="#class">Nombre de la clase</label>
                            <input type="text" class="form-control" id="class" name="lesson" value="" required>
                        </div>
                        <input type="hidden" name="action" value="2">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button submit" class="btn btn-primary">Guardar clase</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit lesson-->
    <div class="modal fade" id="editLesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Clase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="get">
                        @csrf
                        <div class="modal-body">
                            <label for="#elesson">Nombre de la clase</label>
                            <input type="text" class="form-control" id="elesson" name="name" value="" required>
                            <p>¿Deseas eliminar la clase?</p>
                            <input type="checkbox" name="eliminate" id="borrarHora" class="" value="on"> <span
                                class="text-danger">Esto eliminara la clase y todos los horarios de los maestros y
                                salones a los que pertenece</span>
                        </div>
                        <input type="hidden" name="action" value="6">
                        <input type="hidden" name="e_ll" id="e_ll">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button submit" class="btn btn-primary">Guardar clase</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("[id^=lesson]").click(function(a) {
                //Obtener id
                var id = $(this).attr("id");
                id = id.split("-");
                var h = id[1];
                //obtener clase y salon
                var str = $(this).text();
                //Dar valores al modal
                $("#e_ll").val(h);
                $("#elesson").val(str);
            });
        });
    </script>
@endsection
