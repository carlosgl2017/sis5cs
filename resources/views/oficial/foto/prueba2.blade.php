
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
<div class="box-header" >
<form action="{{url('oficial/foto/prueba2/')}}">
<div class="box-header" >
<h3> Seleccione Solo  de 3 a 12 Fotos </h3>
   <div class="form-group">   
    <label>Crear Reporte de Fotografias</label>
 <div style="width: 30%"> 
 
     <div> <textarea name ="titulo" rows="4"  cols="50" required >Escriba el Titulo del Reporte</textarea></div>
     
     <div> 
     <input type="submit" class="btn btn-primary"  value="Crear Reporte" >
    
     
     
     </div>
       
</div>

  </div>
 
@if(session('notification'))
<div class="alert alert-success">
   {{session('notification')}}
</div>
@endif

<!-- /.box-header -->
<div class="box-body">


  <table id="other3" class="table table-bordered table-striped" >
    <div id="div1">
    <thead>
      <tr>
      <th>Nº</th>
       <th>Fecha</th>
       
       <th>Foto</th>
       <th>Descripcion</th>
       <th>Acciones</th>               
     </tr>
   </thead>
   <tbody>
  @foreach ($fotos as $fo)
    <tr> 
       <td>{{$loop->iteration}}</td>   
      <td>{{$fo->created_at}}</td>
      
      <td>
						<img src="{{asset('images/fotos/'.$fo->archivo)}}" alt="{{ $fo->archivo}}" height="75px" width="75px" class="img-thumbnail">
            <input type="checkbox" name="id_foto[]" value="{{$fo->id_foto}}" id="2"></br>
			</td>
      </form>
      <td>   {{$fo->detalle}}  </td> 
      
      <td> 
      
      <a href="{{url('/oficial/foto/'.$fo->id_foto.'/descarga')}}" rel="tooltip" title="Descargar fotografía" class="btn btn-success btn-simple btn-xs">
        <i class="fa fa-download"></i> 
      </a>
    </td>
  </tr>
  @include('oficial.foto.modal')
  
  @endforeach
</tbody> 
</div>               
</table>
</div>
<!-- /.box-body -->

@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liArchivos').addClass("treeview active");
  $('#liFotos').addClass("active");
</script>
@endpush
@endsection


