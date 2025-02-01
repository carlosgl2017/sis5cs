@extends ('layouts.admin3')
@section ('contenido')
<!-- div usuario seleccionado-->
<div class="box-body">
  <div class="col-md-5 col-sm-4 col-xs-12 pull-right">
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

<!-- Horizontal Form -->
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Seguimiento del Crédito</h3>
  </div>
  <div class="box-header">
    @if(session('notification'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Notificación</h4>
      {{session('notification')}}.
    </div>
    @endif
    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
      <a href="{{url('/jefecredito/seguimiento/reporte')}}" class="btn btn-block btn-social btn-dropbox">
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
          <th colspan="3">Observaciones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; ?>

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
          <td colspan="3">
            @if($se->completado==true)
            <span class="label label-success">Completado</span>
            @if($i==0)
            <a href="{{url('/jefecredito/seguimiento/'.$se->id_seguimiento.'/modificar')}}" rel="tooltip" title="Editar" class="btn btn-success btn-simple btn-xs">
              <i class="fa fa-pencil"></i>
            </a>
            @endif
            @else
            <a href="{{url('/jefecredito/seguimiento/'.$se->id_seguimiento.'/edit_derivar')}}"><button class="btn btn-warning">Derivar</button></a>
            @endif
          </td>

          <?php $i++ ?>
        </tr>
        @endforeach   
      </tbody>
    </table>
  </div>

</div>

<!-- /.box-body -->
@include('sweetalert::alert')
@push ('style')
<style>
  .table-footer {
    background: #D1D2F9;
    font-weight: bold;
  }
</style>
@endpush
@endsection