@extends ('layouts.admin3')
@section ('contenido')

<div class="box">
  <div class="box-header">
    <h3>Listar visitas de seguimiento
    </h3>
  </div>


  @if(session('notification'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notificación</h4>
    {{session('notification')}}.
  </div>
  @endif

  <!-- /.box-header -->
  <div class="box-body">
    <table id="visita" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>Fecha de visita</th>
          <th>Hora de visita</th>
          <th>Tiempo de ducación (min)</th>
          <th>Fecha de programación</th>
          <th>Direccion de visita</th>
          <th>Departamento</th>
          <th>Ciudad</th>
          <th>Provincia</th>
          <th>Localidad</th>
          <th>Nombre Oficial</th>
          <th>Aprobado</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($visitas as $vi)
        <tr>
          <td>{{$vi->id_visita}}</td>
          <td>{{$vi->fecha_visita}}</td>
          <td>{{$vi->hora_visita}}</td>
          <td>{{$vi->duracion_minutos}}</td>
          <td>{{$vi->fecha_programacion}}</td>
          <td>{{$vi->direccion}}</td>
          <td>{{$vi->departamento}}</td>
          <td>{{$vi->ciudad}}</td>
          <td>{{$vi->provincia}}</td>
          <td>{{$vi->localidad}}</td>
 	  <td>{{$vi->name}}</td>

          <td>@if($vi->aprobado==0)
            <span class="label label-warning">PENDIENTE</span>
            @elseif($vi->aprobado==1)
            <span class="label label-success">APROBADO</span>
            @elseif($vi->aprobado==2)
            <span class="label label-danger">RECHAZADO</span>
            @endif
          </td>
          <td>
            @if($vi->estado==true)
            <span class="label label-success">REALIZADO</span>
            @else
            <span class="label label-danger">PROGRAMADO</span>
            @endif
          </td>
          <td> <a href="{{url('/jefecredito/visitas/'.$vi->id_visita.'/edit')}}" rel="tooltip" title="Aprobar visita" class="btn btn-success btn-simple btn-xs">
              <i class="fa fa-thumbs-o-up text-white"></i>
            </a>  
            <a href="{{url('/jefecredito/visitas/'.$vi->id_visita.'/denegar')}}" rel="tooltip" title="Rechazar visita" class="btn btn-danger btn-simple btn-xs">
              <i class="fa fa-thumbs-o-down text-white"></i>
            </a>          
            </td>
            
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liJefe_marcar').addClass("active");
</script>
@endpush
@endsection