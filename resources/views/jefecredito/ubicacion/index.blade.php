@extends ('layouts.admin3')
@section ('contenido')

<div class="box">
  <div class="box-header">
    <h3>Lista de visitas de seguimiento
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
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>ESTADO</th>
          <th>Nombre Oficial</th>
          <th>Acciones</th>
          
        </tr>
      </thead>
      <tbody>
        @foreach ($visitas as $vi)
        <tr>
          <td>{{$vi->id_visita}}</td>
          
          <td>
            @if($vi->estado==true)
            <span class="label label-success">REALIZADO</span>
            @else
            <span class="label label-danger">PROGRAMADO</span>
            @endif
          </td>
          <td>{{$vi->name}}</td>
          <td> <a href="{{url('/jefecredito/visitas/'.$vi->id_visita.'/ubicacion')}}" rel="tooltip" title="Ver  visita" class="btn btn-success btn-simple btn-xs">
              <i class="fa fa-eye  text-white"></i>
            </a>  
            <a href="{{url('/jefecredito/visitas/'.$vi->id_visita.'/denegar')}}" rel="tooltip" title="Reporte visita" class="btn btn-danger btn-simple btn-xs">
              <i class="fa fa-thumbs-o-down text-white"></i>
            </a>          
            </td>
            
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.box-body -->

@include('sweetalert::alert')

@endsection