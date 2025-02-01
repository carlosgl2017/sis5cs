<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
  table { 
    border-spacing: 20px;
    border-collapse: separate;
}
.fondo_salmon{
    background-color: #0E538E  ;
    color: white;
    align: center;
}
h3 { 
    display: block;
    background-color: #0E538E ;
    color: white;
    font-size: 1.17em;
    margin-top: 1em;
    margin-bottom: 1em;
    margin-left: 0;
    margin-right: 0;
    font-weight: bold;
}
.foto2 { padding: 10px; margin: 10px; border: 2px solid black; float: right; width: 250px; }
  </style>
<head>
    <table id="mytable"   border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
      <tr>          
       <td>                     
          <br>
              <small> <em><i style="color:#B73451"; > Creacion Reporte: {{$now}}  </i></em> </small> </td>
      </td>
       <td valign="top" align="right"><left><small><em><p style="color:#B73451"; >Cooperativa de Ahorro y Credito Societaria  <br>                                           
              San Martin  R.L.&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
              </p></em></small></td>
      <td   width="50" heigth="50" valign="top"><img src="{{public_path('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >   
      </td>            
       </tr>
        </table>   
        </head>     
      <body>        
      
      <center>
      <table>
        <h3>Grafico Estado de Visitas</h3>
      <td class=fondo_salmon colspan="3"align="center" >Datos </td>
      
      <img src="{{$base64}}" height="700px" width="700px" class="foto1">
        <tr>
        <th>Nombre</th>
        <th>Numero de Visitas</th>
        </tr>
        @foreach($visitaanio as $vi)
        <tr>
          <td>{{$vi->name}}</td>
          <td align="center">{{$vi->total}}</td>
        </tr>@endforeach
        <tr>
         <th>TOTAL</th>
         <td align="center">{{$visitaaniototal}}</td>
        </tr>
        <tr>
         <th>Fecha-Año Visita</th>
         <td  align="center">{{$anio}} {{$anio2}}</td> 
        </tr>
      </table>
</center>
<br></br><br></br><br></br><br></br><br></br>
<table id="mytable"   border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
      <tr>          
       <td>                     
          <br>
              <small> <em><i style="color:#B73451"; > Creacion Reporte: {{$now}}  </i></em> </small> </td>
      </td>
       <td valign="top" align="right"><left><small><em><p style="color:#B73451"; >Cooperativa de Ahorro y Credito Societaria  <br>                                           
              San Martin  R.L.&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
              </p></em></small></td>
      <td   width="50" heigth="50" valign="top"><img src="{{public_path('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >   
      </td>            
       </tr>
        </table> 
    
      <center>
      <table >
      <h3>Grafico Estado de Salidas </h3>
      <td class=fondo_salmon colspan="3"align="center" >Datos </td>
      <img src="{{$base642}}" height="700px" width="700px">
        <tr>
        <th>Nombre</th>
        <th>Numero de Salidas</th>
        </tr>
        @for($i=0;$i<3;$i++)
        <tr>
          <td>{{$nombres[$i]}}</td>
          <td align="center">{{$salidas2[$i]}}</td>
        </tr>@endfor
         <tr>
         <th>TOTAL</th>
         <td align="center">{{$totalsalidas}}</td>
        </tr>
         <tr>
         <th>Fecha-Año Salida</th>
         <td  align="center">{{$anio}} {{$anio2}}</td>
         
        </tr>
      </table>
</center>
      </body>
</html>



