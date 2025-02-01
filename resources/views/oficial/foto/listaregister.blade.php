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
    <div class="alert alert-success">
      {{session('notification')}}
    </div>
    @endif
    <h3>Lista de Registros de Socios App Movil</h3><br>
    <a href="{{url('/oficial/foto/register')}} " class="btn btn-success pull-middle" style="margin-top: -8px;">Registrar Nuevo Usuario </a>

    <table id="other" class="table table-bordered table-striped"> 
        <thead>
          <tr>
            <th>Nº</th>
            <th>ID Persona</th>
            <th>Nombre de Socio</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Fecha Creacion</th>
            <th>Actualizar</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $us)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$us->id_persona}}</td>
            <td>{{$us->nombre}} {{$us->ap_paterno}} {{$us->ap_materno}}</td>
            <td>{{$us->name}}</td>
            <td>{{$us->email}}</td>
            <td>{{$us->created_at}}</td>
            <td><a href="{{url('/oficial/foto/'.$us->id_users.'/edituser')}}" rel="tooltip" title="Editar foto" class="btn btn-success btn-simple btn-xs">
                <i class="fa fa-pencil"></i>
              </a>
              <a href="" data-target="#modal-delete-{{$us->id_users}}" rel="tooltip" title="Eliminar" data-toggle="modal" class="btn btn-danger btn-simple btn-xs">
                <i class="fa fa-times"></i>

              </a>
            </td>
            <td>
          @if($us->id_rol==10)
          <span class="label label-success">HABILITADO</span>
          @elseif($us->id_rol==5)
          <span class="label label-danger">INHABILITADO</span>
          @endif
        </td>

        <td>
          <a href="{{url('/oficial/foto/'.$us->id_users.'/estado')}}" rel="tooltip" title="Habilitar Cuenta" class="btn btn-success btn-simple btn-xs">
            <i class="fa fa-thumbs-o-up"></i>
          </a>

          <a href="{{url('/oficial/foto/'.$us->id_users.'/estado')}}" rel="tooltip" title="Deshabilitar Cuenta" class="btn btn-danger btn-simple btn-xs">
          <i class="fa fa-thumbs-o-down text-white"></i>
          </a>
        </td>
          </tr>
          @include('oficial.foto.modal2')
          @endforeach
        </tbody>
    </table>
 
</div>

<!-- /.box-body -->

@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liSeguimiento').addClass("treeview active");
  $('#liSeguimiento_usuarios').addClass("active");
</script>
@endpush
@endsection