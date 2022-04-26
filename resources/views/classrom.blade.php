@extends('layouts.app')
@section('title', 'Salon ' . $classrom->classrom)
@section('content')
    @auth
        <style>
            .b1 {
                max-height: 62px;
            }

        </style>
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <div class="row d-flex">
                                <div class="col-2">
                                    <h4 class="mt-3">Salon: {{ $classrom->classrom }}</h4>
                                </div>
                                <div class="col d-flex flex-column align-items-end"">
                                                            <button type=" button" class="btn btn-link" data-bs-toggle="modal"
                                    data-bs-target="#editarSalon">
                                    Editar Salon
                                    </button>
                                    <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                        data-bs-target="#eliminarSalon">
                                        Eliminar Salon
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="fst-italic text-center ">Da click en la clase para editarla</p>
                            <div class="row">
                                <div class="d-flex flex-column col">
                                    <p class="fw-bolder">Hora / Dia</p>
                                    @php
                                        $cont_horas = 0;
                                    @endphp
                                    @foreach ($hoursclass as $h)
                                        {{-- recorre la consulta del horario de cada empleado --}}
                                        @php
                                            $entrada = date_create($h->enter); //crea fecha de entrada
                                            $entrada = date_format($entrada, 'g:i A');
                                            $salida = date_create($h->exit); //crea fecha de salida
                                            $salida = date_format($salida, 'g:i A');
                                            $cont_horas++;
                                        @endphp
                                        <button type="button" class="btn btn-light mb-2" id="hora-{{ $h->id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editarHoraClase">{{ $entrada }}<br>{{ $salida }}</button>
                                        {{-- <div class="mb-2" style="max-height: 62px;">
                                                    <p class="fw-bolder">{{ $entrada }}<br>{{ $salida }}</p>
                                                    
                                                </div> --}}
                                    @endforeach
                                </div>
                                @for ($i = 1; $i < 7; $i++)
                                    <div class="d-flex flex-column col">
                                        @switch($i)
                                            @case(1)
                                                <p class="fw-bolder text-center">Lunes</p>
                                            @break

                                            @case(2)
                                                <p class="fw-bolder text-center">Martes</p>
                                            @break

                                            @case(3)
                                                <p class="fw-bolder text-center">Miercoles</p>
                                            @break

                                            @case(4)
                                                <p class="fw-bolder text-center">Jueves</p>
                                            @break

                                            @case(5)
                                                <p class="fw-bolder text-center">Viernes</p>
                                            @break

                                            @case(6)
                                                <p class="fw-bolder text-center">Sabado</p>
                                            @break

                                            {{-- @case(7)
                                                <p class="fw-bolder text-center">Domingo</p>
                                            @break --}}
                                        @endswitch

                                        @for ($j = 1; $j <= $cont_horas; $j++)
                                            {{ insertarHora($j, $i, $schedule) }}
                                        @endfor
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal editar empleado-->
        <div class="modal fade" id="editarSalon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Salon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="get">
                        @csrf
                        <div class="modal-body">
                            <label for="#nombreEditar">Nombre:</label>
                            <input type="text" class="form-control" id="nombreEditar" name="name"
                                value="{{ $classrom->classrom }} " required>
                            <input type="hidden" name="action" value="1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal eliminar-->
        <div class="modal fade" id="eliminarSalon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Empleado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estas seguro que deseas eliminar el salon?<br>
                        Esta opcion es irreversible, eliminara todos los horarios del salon y el salón.
                    </div>
                    <form action="" method="get">
                        @csrf
                        <input type="hidden" name="action" value="2">
                        <input type="hidden" id="eliminar" name="delete" value="{{ $classrom->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button submit" class="btn btn-primary">Si</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal editar hora-->
        <div class="modal fade" id="editarHora" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Hora</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="get">
                        @csrf
                        <input type="hidden" name="action" value='3'>
                        <input type="hidden" name="day" id="diaForm">
                        <input type="hidden" name="hour" id="horaForm">
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Nombre de la Clase</th>
                                        <td>
                                            <select name="class" class="form-select" aria-label="Default select example"
                                                required>
                                                <option selected>Selecciona la clase</option>
                                                @foreach ($lessons as $ll)
                                                    <option value="{{ $ll->id }}">{{ $ll->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Profesor</th>
                                        <td>
                                            <select name="teacher" class="form-select" aria-label="Default select example"
                                                required>
                                                <option>Selecciona el profesor</option>
                                                @foreach ($teachers as $cl)
                                                    <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Eliminar Hora</th>
                                        <td><input type="checkbox" name="eliminateH" id="borrarHora" class=""
                                                value="on"> <span class="text-danger">Esta opcion eliminara la hora
                                                asignada</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal editar hora clase-->
        <div class="modal fade" id="editarHoraClase" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Hora Clase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="get">
                        @csrf
                        <input type="hidden" name="edit_h" id="edit_h">
                        <input type="hidden" name="action" value="4">
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Hora de inicio</th>
                                        <td>
                                            <input class="form-control" type="time" name="hour1" id="e_hour1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Hora de finalizacion</th>
                                        <td>
                                            <input class="form-control" type="time" name="hour2" id="e_hour2">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        

        <script>
            $(document).ready(function() {
                $("[id^=horario]").click(function(a) {
                    //Obtener id
                    var id = $(this).attr("id");
                    id = id.split("-");
                    var h = id[1];
                    var d = id[2];
                    //Dar valores al modal

                    $("#horaForm").val(h);
                    $("#diaForm").val(d);
                });
                $("[id^=hora]").click(function(b) {
                    var id = $(this).attr("id");
                    id = id.split("-");
                    var nid = id[1];
                    $('#edit_h').val(nid);
                });
            });
        </script>
    @endauth
@endsection

@php
function insertarHora($hora, $dia, $horasclase)
{
    $band = 0;
    foreach ($horasclase as $c) {
        if ($c->day == $dia && $c->time == $hora) {
            echo '<button type="button" class="btn btn-light mb-2 b1" id="horario-' . $hora . '-' . $dia . '" data-bs-toggle="modal" data-bs-target="#editarHora">' . $c->class . '<br>' . $c->employer . '</button> ';
            $band = 1;
        }
    }
    if ($band == 0) {
        echo '<button type="button" class="btn btn-light mb-2" id="horario-' . $hora . '-' . $dia . '" data-bs-toggle="modal" data-bs-target="#editarHora">ㅤ<br>ㅤ</button>';
    }
}
@endphp
