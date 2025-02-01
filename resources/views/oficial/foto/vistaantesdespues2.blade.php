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

<h3> Seleccione Solo 3 fotos de la Tabla "Antes" y 3 fotos de la Tabla "Despues" </h3>

 
  

<form action="{{url('oficial/foto/vistaantesdespues2/')}}" >
   <div class="form-group">   
    <label>Crear Reporte</label>
    <div style="width: 30%"> 
    
   
     <div> <textarea name ="titulo" rows="4"  cols="50">Escriba el Titulo del Reporte</textarea></div>
       
     <div align="left"> 
     <input type="submit" class="btn btn-primary"  value="Crear Reporte"  >
     
     
     
 

</div></div>
 
@if(session('notification'))
<div class="alert alert-success">
   {{session('notification')}}
</div>
@endif

<!-- /.box-header -->
<div class="box-body">
  <table id="other1" class="table table-bordered table-striped" >
  <caption> TABLA ANTES</caption>
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
            <input type="checkbox" name="id_foto1[]" value="{{$fo->id_foto}}" id="2" onclick="guardar()"></br>
			</td>
      
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




<table id="other3" class="table table-bordered table-striped" >
<caption> TABLA DESPUES</caption>
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
  @foreach ($fotos2 as $fo)
    <tr> 
       <td>{{$loop->iteration}}</td>   
      <td>{{$fo->created_at}}</td>
      <td>
						<img src="{{asset('images/fotos/'.$fo->archivo)}}" alt="{{ $fo->archivo}}" height="75px" width="75px" class="img-thumbnail">
            <input type="checkbox" name="id_foto2[]" value="{{$fo->id_foto}}" id="id_foto2[]" onclick="validacion(this)"></br>
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
<script>
     function guardar() {
    var sel=[],nosel=[];
    $('form input:checkbox').map(function(){
        if($(this).prop('checked')){
          sel.push($(this).val());
        }else{
          nosel.push($(this).val());
        }
    })
    console.log("seleccionados");console.log(sel);
    console.log("no seleccionados");console.log(nosel);
}
</script>
<script>
     function guardar2() {
    var sel=[],nosel=[];
    num=$(this).val();
    num2 =
    $('form input:checkbox').map(function(){
        if($(this).prop('checked') ){
          sel.splice($(this).val());
          num++;
          }
          else{
            nosel.push($(this).val()+'b');
           //num++;
          }
        
        
    })
    console.log("seleccionados");console.log(sel);
    console.log("no seleccionados");console.log(nosel);
}
</script>

<script>
//este script valida solo 3 campos de seleccion
function validacion(obj) {
  limite=6;
  num=0;
  if (obj.checked) {
    for (i=0; ele=obj.form.elements[i]; i++)
      if (ele.checked) 
      num++;
      
  if (num>limite)
    obj.checked=false;
  
  }
  console.log("seleccionados");console.log(obj.val);
    //console.log("no seleccionados");console.log(nosel);
}
</script>
@endpush
@endsection


