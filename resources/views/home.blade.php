@extends('layouts.app')
@section('title','Lista')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @auth
            <div class="col-2 d-flex flex-column">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarEmpleado">Agregar Empleado</button>
                <div class="card mt-2" style="">
                    <div class="card-body">
                      <h6 class="card-title">Filtro</h6>
                      <form action="/home" method="get">
                          @csrf
                          <label for="idate">Fecha Inicial</label>
                          <p>{{$idate}}</p>
                          <label for="edate">Fecha Final</label>
                          <p>{{$edate}}</p>
                          <label for="date">Escoge la quincena</label>
                          <select class="form-select" aria-label=".form-select-lg example" name="q_date">
                            @foreach ($q as $n)
                                <option value="{{$n->id}}|">{{date("d-m-Y",strtotime($n->date))}}</option>
                            @endforeach
                          </select>
                          <button type="button submit" class="btn btn-primary mt-1">Aplicar Filtro</button>
                      </form>
                    </div>
                  </div>
            </div>
        
        <div class="container col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Listado Empleados') }}</div>
                    <div class="card-body">
                    @auth
                    <table class="table">
                        <thead>
                          <th class="col-4 text-left">Nombre</th>
                          <th class="col-2 text-center">Clave</th>
                          <th class="col-2 text-center">Faltas</th>
                          <th class="col-2 text-center">Retardos</th>
                          <th class="col-2 text-center">Más</th>
                        </thead>
                        <tbody>
                          @foreach ($employers as $e)
                              <tr>
                                <td>{{$e->name}}</td>
                                <td class="text-center">{{$e->id}}</td>
                                <td class="text-center">{{$e->delays}}</td>
                                <td class="text-center">{{$e->absences}}</td>
                                <td class="text-center"><a href="{{url('/empleado/'.$e->id)}}">Ver Más</a></td>
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
                    @else
                        <p class="text-center">Necesitas Ingresar</p>
                    @endauth
                </div>
            </div>
        </div>
        @endauth
    </div>
</div>
  <!-- Modal add employer-->
  <div class="modal fade" id="agregarEmpleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Empleado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form action="/agregarEmpleado" method="post">
                @csrf
                <div class="modal-body">
                    <label for="#id">Id:</label>
                    <input type="number" class="form-control" id="id" name="id" min="1" step="1.0" value="" required>
                    <div id="passwordHelpBlock" class="form-text">
                      No olvides que el ID debe de ser el mismo que el que esta en el CSV
                    </div>
                    <label for="#name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" value="" required>
                    <label for="#department">Departmento:</label>
                    <input type="text" class="form-control" id="department" name="department" value="" required>
                    <label for="#job">Puesto:</label>
                    <input type="text" class="form-control" id="job" name="job" value="" required>
                    <label for="#salary">Sueldo:</label>
                    <input type="number" class="form-control" id="salary" name="salary" min="0" step="1.0" value="" required>
                </div>
                <input type="hidden" name="agregar" value="1">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button submit" class="btn btn-primary">Guardar Empleado</button>
                  </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  
@endsection
