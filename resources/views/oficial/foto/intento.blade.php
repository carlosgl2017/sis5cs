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
<!-- div usuario seleccionado-->


<div class="box-header">

  <h3> Crédito de Seguimiento: {{$idfoto}} </h3>

  <form action="">


    @if(session('notification'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Notificación</h4>
      {{session('notification')}}.
    </div>
    @endif

    <h3>Lista de Carpetas de Fotografias</h3>
    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
      <a href="{{url('/oficial/foto/fotodetalle')}}" class="btn btn-block btn-social btn-dropbox">
        <i class="fa fa-plus-square"></i>Añadir Carpeta de Fotos
      </a>
    </div>
</div>

<!-- /.box-header -->
<div class="box-body">


  <table id="other2" class="table table-bordered table-striped">
    <div id="div1">
      <thead>
        <tr>
          <th>Nº</th>
          <th>Titulo</th>
          <th>Fecha Creacion</th>
          <th>Cantidad de Fotos</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($seguimientofoto as $fo)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$fo->descripcion}}</td>

          </form>
          <td> {{$fo->created_at}} </td>
          <td>{{$fo->count}}</td>

          <td>
            <a href="{{url('/oficial/foto/'.$fo->id_seguimiento_foto.'/listafoto')}}" rel="tooltip" title="Ver Imagenes" class="btn btn-success btn-simple btn-xs">
              <i class="fa fa-eye "></i>
            </a>
            <!--  <a href="" data-target="#modal-delete-{{$fo->id_seguimiento_foto}}" rel="tooltip" title="Eliminar" data-toggle="modal" class="btn btn-danger btn-simple btn-xs">
                         <i class="fa fa-times"></i> 
      </a>-->
          </td>
        </tr>


        @endforeach
      </tbody>
    </div>
  </table>
</div>
<!-- /.box-body -->

@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liSeguimiento').addClass("treeview active");
  $('#liSeguimiento_fotografias').addClass("active");
</script>
@endpush
@endsection