<html>
<style>
#titulo{
    background:#FBFAF8;
    color: #64D447 ;
}
.fondo_salmon{
    background-color: #0E538E  ;
    color: white;
    align: center;
}
table { 
    border-spacing: 30px;
    border-collapse: separate;
}
</style>
@foreach ($datos as $da)
<table    border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
    <tr>    <td>
                  <small> <em><i style="color:#B73451"; >Oficial de Credito:  {{$name}}</i></em></small>
                    
                   <br>
                   
                 <small> <em><i style="color:#B73451"; >Fecha Creacion Reporte:  {{$now}} </i></em> </small> </td>
                 </td>
                 <td valign="top" align="right"><left><small><em><p style="color:#B73451"; >Cooperativa de Ahorro y Credito Societaria  <br>                                          
       &nbsp;&nbsp;&quot;San Martin&quot; R.L. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   </p></em></small></td>
                   
                    <td   width="5" heigth="5" valign="top"> <img src="{{public_path('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >
                   
            </td> 
                    
          </tr> 
        
        </table>    
                  
                  
    
<body >
        <br></br>        
   <table border="0" width="100%"  align="center" >
   <caption ><h3><pre style="white-space: normal"><font size="3" FACE="times new roman">FORMULARIO DE VERIFICACION</font> </pre></h3></caption>  

       <tr>
       <td class=fondo_salmon colspan="3"align="center" >INFORMACION SECUNDARIA DEL SOCIO</td>
       </tr>
       <tr>
       <td width="30%">Numero de Credito:</td>
       <td>{{$da->id_credito}}</td>
       </tr>
       <tr>
       <td>Tipo de Credito</td>
       <td>{{$da->tipo_credito}}</td>
       </tr>
       <tr>
       <td>Id Visita:</td>
       <td>{{$da->id_visita}}</td>
       </tr>
       <tr>
       <td>Fecha Visita:</td>
       <td>{{$fecha}}</td>
       </tr>
      

   
   </table>
   <br></br>
   <table border="0" width="100%"  align="center" >
   <tr>
       <td class=fondo_salmon colspan="3"align="center" >INFORMACION PERSONAL DEL SOCIO</td>
       </tr>
       <tr>
       <td width="30%">Nombre(s)</td>
       <td>{{$da->nombre}}</td>
       </tr>
       <tr>
       <td>Apellido(s)</td>
       <td>{{$da->ap_paterno}} {{$da->ap_materno}}</td>
       </tr>
       <tr>
       <td>Ci:</td>
       <td>{{$da->ci}}</td>
       </tr>
       <tr>
       <td>Estado Civil:</td>
       <td>{{$da->estado_civil}}</td>
       </tr>
       <tr>
       <td>Celular:</td>
       <td>{{$da->celular}}</td>
       </tr>
   
   </table>
   <br></br>
   <table border="0" width="100%" >
   <tr>
       <td class=fondo_salmon colspan="3" align="center">INFORMACION DEL LUGAR DE VISITA</td>
       </tr>
       <tr>
       <td width="30%">Ciudad:</td>
       <td>{{$da->ciudad}}</td>
       </tr>
       <tr>
       <td>Departamento:</td>
       <td>{{$da->departamento}}</td>
       </tr>
       <tr>
       <td>Localidad:</td>
       <td>{{$da->localidad}}</td>
       </tr>
       <tr>
       <td>Provincia:</td>
       <td>{{$da->provincia}}</td>
       </tr>
       <tr>
       <td>Direccion:</td>
       <td>{{$da->direccion}}</td>
       </tr>
</table>

  
  </body>
  @endforeach
  
  </html>
   