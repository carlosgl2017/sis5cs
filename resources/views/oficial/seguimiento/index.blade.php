@extends ('layouts.admin3')
@section ('contenido')
<!-- div usuario seleccionado-->
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
<!-- div usuario seleccionado-->
<div class="box-header">

  @if(session('notification'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notificación</h4>
    {{session('notification')}}.
  </div>
  @endif

  <h3>Gestionar Seguimiento</h3>
   <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
    <a href="{{url('/oficial/seguimiento/reporte')}}" class="btn btn-block btn-social btn-dropbox">
      <i class="fa fa-print"></i>Generar Reporte
    </a>
  </div>
</div>
<!-- /.box-header -->
<div class="box-body">
  <table class="table table-bordered table-striped ">
    <thead style="background-color:#007CBE; color:white">
      <tr>
        <th>Id</th>
        <th>Fecha Inicio Atención</th>
        <th>Fecha Fin de Atención</th>
        <th>Tiempo de atención</th>
        <th>Funcionario Actual</th>
        <th>Área Actual</th>
        <th>Funcionario Destino</th>
        <th>Área Destino</th>
        <th>Observaciones</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($seguimiento as $se)
      <tr>
        <td>{{$se->id_seguimiento}}</td>
        <td>{{$se->fecha_inicio}}</td>
        <td>{{$se->fecha_fin}}</td>
        <?php
        $cadena = \Carbon\Carbon::parse($se->fecha_inicio)->diffForHumans(\Carbon\Carbon::parse($se->fecha_fin)); ?>
        <td>{{substr($cadena, 0, strpos($cadena, "antes"))}}</td>
        <td>{{$se->name}}</td>
        <td>{{$se->area}}</td>

        <td>
          @foreach ($usuarios as $u)
          @if($u->id_users==$se->usuario_destino)
          {{$u->name}}
          @endif
          @endforeach
        </td>
        <td>
          @foreach ($areas as $a)
          @if($a->id_area==$se->area_destino)
          {{$a->area}}
          @endif
          @endforeach
        </td>
        <td>{{$se->observaciones}}</td>
        <td>
          @if($se->completado==true)
          <span class="label label-success">Completado</span>
          @else
          <a href="{{url('/oficial/seguimiento/'.$se->id_seguimiento.'/edit_derivar')}}"><button class="btn btn-warning">Derivar</button></a>
          @endif
        </td>
      </tr>

      @endforeach
    </tbody>
  </table>
</div>
<!-- /.box-body -->
@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liSeguimiento').addClass("treeview active");
  $('#liSeguimiento_seguimiento').addClass("active");
</script>
@endpush
@endsection