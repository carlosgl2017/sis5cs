@extends ('layouts.admin3')
@section ('contenido')
<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="fa fa-user-circle-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text"> Socio seleccionado:</span>
        <span class="info-box-number">{{session('id_persona_oficial','Usuario no seleccionado')}}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 70%"></div>
        </div>
        <span class="progress-description">
          Crédito: {{session('id_credito','Crédito no seleccionado')}}
        </span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</div>

<div class="box-header">

  @if(session('notification'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notificación</h4>
    {{session('notification')}}.
  </div>
  @endif

  <h3>Gestionar Visitas de seguimiento</h3>
  <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
    <a href="{{url('/oficial/visitas/create')}}" class="btn btn-block btn-social btn-dropbox">
      <i class="fa fa-plus-square"></i>Programar visita
    </a>
  </div>
</div>

<!-- /.box-header -->
<div class="box-body">
  <table id="o_direccion" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Id</th>
        <th>Fecha Visita</th>
        <th>Hora Visita</th>
        <th>Duración</th>
        <th>Fecha programación</th>
        <th>direccion</th>
        <th>Aprobado</th>
        <th>Estado</th>
        <th>Acción</th>
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
        <td>@if($vi->aprobado==0)
          <span class="label label-warning">PENDIENTE</span>
          @elseif($vi->aprobado==1)
          <span class="label label-success">APROBADO</span>
          @elseif($vi->aprobado==2)
          <span class="label label-danger">RECHAZADO</span>
          @endif
        </td>
        <td>
          @if($vi->estado==false)
          <span class="label label-danger">PROGRAMADA</span>
          @else
          <span class="label label-success">REALIZADA</span>
          @endif
        </td>

        <td>
          <a href="{{url('/oficial/visitas/'.$vi->id_visita.'/realizada')}}" rel="tooltip" title="Marcar visita Realizada" class="btn btn-success btn-simple btn-xs">
            <i class="fa fa-thumbs-o-up"></i>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <!--  Suma del total-->
</div>
<!-- /.box-body -->
@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liSeguimiento').addClass("treeview active");
  $('#liSeguimiento_visitas').addClass("active");
</script>
@endpush
@endsection