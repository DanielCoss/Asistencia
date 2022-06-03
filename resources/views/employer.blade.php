@extends('layouts.app')
@section('title', $employer->name)
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @auth
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $employer->name }}</h4>
                            <div class="row d-flex">
                                <div class="col-2 text-start">
                                    <p class="font-weight-bold ">Departamento: {{ $employer->department }}<br>Puesto:
                                        {{ $employer->job }}</p>
                                </div>
                                <div class="col-2 text-start">
                                    <p class="font-weight-bold ">Clave: {{ $employer->id }} <br> Sueldo:
                                        {{ $employer->salary }}
                                    </p>
                                </div>
                                <div class="col d-flex flex-column align-items-end"">
                                                                            <button type=" button" class="btn btn-link"
                                    data-bs-toggle="modal" data-bs-target="#editarEmpleado">
                                    Editar Empleado
                                    </button>
                                    <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                        data-bs-target="#eliminarEmpleado">
                                        Eliminar Empleado
                                    </button>
                                </div>
                            </div>
                        </div>
                        <nav class="mt-2">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Calendario</button>
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                    aria-selected="false">Horario</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="card-body">
                                    <div class="container" id="div-calendario">
                                        <div id='calendar'></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="container pt-2">
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
                                        @for ($i = 1; $i < 8; $i++)
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

                                                    @case(7)
                                                        <p class="fw-bolder text-center">Domingo</p>
                                                    @break
                                                @endswitch

                                                @for ($j = 1; $j <= $cont_horas; $j++)
                                                    {{ insertarHora($j, $i, $schedule) }}
                                                @endfor
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Modal editar empleado-->
    <div class="modal fade" id="editarEmpleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="get">
                    @csrf
                    <div class="modal-body">
                        <label for="#nombreEditar">Nombre:</label>
                        <input type="text" class="form-control" id="nombreEditar" name="name"
                            value="{{ $employer->name }} " required>
                        <label for="#departamentoEditar">Departamento:</label>
                        <input type="text" class="form-control" id="departamentoEditar" name="department"
                            value="{{ $employer->department }}" required>
                        <label for="#puestoEditar">Puesto:</label>
                        <input type="text" class="form-control" id="puestoEditar" name="job"
                            value="{{ $employer->job }}" required>
                        <label for="#sueldoEditar">Sueldo:</label>
                        <input type="number" class="form-control" id="sueldoEditar" name="salary" min="0" step=".01"
                            value="{{ $employer->salary }}" required>
                        <input type="hidden" name="edit" value="1">
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
    <div class="modal fade" id="eliminarEmpleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estas seguro que deseas eliminar al empleado?<br>
                    Esta opcion es irrevertible, eliminara todos los horarios del empleado y al empleado.
                </div>
                <form action="" method="get">
                    @csrf
                    <input type="hidden" id="eliminar" name="eliminate" value="{{ $employer->id }}">
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
                    <input type="hidden" name="day" id="diaForm">
                    <input type="hidden" name="hour" id="horaForm">
                    <input type="hidden" name="id" value="{{ $employer->id }}">
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
                                    <th>Salon</th>
                                    <td>
                                        <select name="classrom" class="form-select" aria-label="Default select example"
                                            required>
                                            <option>Selecciona el salon</option>
                                            @foreach ($classroms as $cl)
                                                <option value="{{ $cl->id }}">{{ $cl->classrom }}</option>
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

    {{-- Modal para editar asistencia del usario --}}
    <div class="modal fade" id="editarAsistencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/editarAsistencia" id="formAsistencia" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id_a" value="{{$employer->id}}">
                    <input type="hidden" name="date" id="date_a">
                    <div class="modal-body">
                        <div class="form-check">
                            <h5>Cambiar la asistencia del empleado</h5>
                            <input class="form-check-input" type="radio" id="asistencia" name="status" value="asistance" required>
                            <label for="asistencia">Asistencia</label><br>
                            <input class="form-check-input" type="radio" id="falta" name="status" value="absent">
                            <label for="falta">Falta</label><br>
                            <input class="form-check-input" type="radio" id="retardo" name="status" value="delay">
                            <label for="retardo">Retardo</label>
                        </div>
                        <label for="note_a">Nota del motivo del cambio</label>
                        <input class="form-control" type="text" name="note" id="note_a" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="guardarAsistencia" type="button submit" class="btn btn-primary">Guardar Cambios</button>
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
                //obtener clase y salon
                var str = $(this).text();
                str = str.split('\n');
                console.log(str);
                var c = str[0];
                var s = str[1];
                //Dar valores al modal
                $("#claseTextBox").val(c);
                $("#salonTextBox").val(s);
                $("#salonTextBox").text(s);
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
@endsection

@php
function insertarHora($hora, $dia, $horasclase)
{
    $band = 0;
    foreach ($horasclase as $c) {
        if ($c->day == $dia && $c->time == $hora) {
            echo '<button type="button" class="btn btn-light mb-2" id="horario-' . $hora . '-' . $dia . '" data-bs-toggle="modal" data-bs-target="#editarHora">' . $c->class . '<br>' . $c->classrom . '</button> ';
            $band = 1;
        }
    }
    if ($band == 0) {
        echo '<button type="button" class="btn btn-light mb-2" id="horario-' . $hora . '-' . $dia . '" data-bs-toggle="modal" data-bs-target="#editarHora">ㅤ<br>ㅤ</button>';
    }
}
@endphp
