@extends ('layouts.admin3')
@section ('contenido')






@if(session('notification'))
<div class="alert alert-success">
   {{session('notification')}}
</div>
@endif
<ul>
      @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ul>


<!-- /.box-header -->

<div class="box-header" >
<form method="post" action="{{url('oficial/foto/createregister')}}">
  {{csrf_field()}}
  <div class="row">
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
    <h4>Registro</h4>
      <div class="form-group">

       <label for="ci">Nombre</label>
       <div class="form-group">
       <div class="col-lg-10">
       <input type="text" name="name" class="form-control" placeholder="Nombre..." value="{{session('id_persona_oficial','Usuario no seleccionado')}}" required>
       </div>
       </div>

       <br></br>

       <label for="ap_casada">Correo Electronico</label>
        <div class="form-group">
        <div class="col-lg-10">
           <input type="email" name="email" class="form-control" placeholder="....@sanmartin.com.bo"   required>
        </div>
        </div>

       <br></br>
        <label for="ap_materno">Contraseña</label>
        <div class="form-group">
          <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
        <div class="col-lg-10">
           <input id="txtPassword"type="password" name="password" class="form-control" placeholder="Contraseña..."required>
         </div>
         </div>
       
       <label for="fec_nac">Repetir Contraseña</label>
       <div class="form-group">
       <button id="show_password2" class="btn btn-primary" type="button" onclick="mostrarPassword2()"> <span class="fa fa-eye-slash icon"></span> </button>
         <div class="col-lg-10">
           <input id="txtPassword2" type="password" name="password_confirmation" class="form-control" placeholder="repetir contraseña..." required>
       </div>
       </div>
         <p></p>
       <button class="btn btn-primary" type="submit">Guardar</button>
      <a href="{{url('/oficial/foto/listaregister')}}" class="btn btn-danger"> cancelar</a>
     
   </div>
</div>
</form>


</div>
@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liArchivos').addClass("treeview active");
  $('#liFotos').addClass("active");
</script>
<script type="text/javascript">
function mostrarPassword(){
		var cambio = document.getElementById("txtPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>
<script type="text/javascript">
function mostrarPassword2(){
		var cambio = document.getElementById("txtPassword2");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>
@endpush
@endsection
