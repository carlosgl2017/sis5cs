<html>
<body>
<head>
<table    border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
    <tr>@foreach ($tipocred as $tip)
      <td  width="420px" > <left><small><em><i style="color:#B73451"; >Tipo Credito: {{$tip->tipo_credito}} </i></em></small><br>
      @endforeach 
                                     
                  @foreach ($nombre as $nom)
                  <small> <em><i style="color:#B73451"; >Nombre: {{$nom->nombre}}  {{$nom->ap_paterno}} {{$nom->ap_materno}} </i></em></small>
                    
                    @endforeach <br>
                    <small> <em><i style="color:#B73451"; > Creacion Reporte: {{$now}} </i></em> </small> </td>
                 <td valign="top" align="right"><left><small><em><p style="color:#B73451"; >Cooperativa de Ahorro y Credito Societaria  <br>                                          
       &nbsp;&nbsp;&quot;San Martin&quot;  R.L. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   </p></em></small></td>
                   
                    <td   width="5" heigth="5" valign="top"> <img src="{{public_path('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >
                   
            </td> 
                    
          </tr> 
        
        </table>    
                  
                  
</head>
    
<body >
        <br></br>        
   <table width="80%"  align="center" >
   <caption  style="color:#3E3E8B";><pre style="white-space: normal"><ins><font size="3" FACE="times new roman">{{$titulo}} </font> </ins></pre></caption>  
   </table>
   <br></br>
   <table border="0" width="100%"
   align="center"  cellspacing="3" cellpadding="3" >
  
   
  @for($i=0 ;$i<$hptam3;$i++ )
      @switch($i)

        @case(0)
          @foreach($coll1[0] as $pe)
             <tr><td style="color:#3E3E8B"; height="-30" align="center" ><ins>ANTES</ins></td>
                <td style="color:#3E3E8B"; height="-30" align="center" ><ins>DESPUES</ins></td></tr>
           <tr>
           
           <td  align="center" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
           
    
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll2[0] as $pe)
          
          <td align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
            </tr>  
          @endforeach
            @break
          
        @case(2)
          @foreach($coll1[1] as $pe)
          <tr>
          <td  align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
           
           
           
          @endforeach
          @break
       @case(3)
       @foreach($coll2[1] as $pe)
         
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
           
           </tr> 
        
          @endforeach
         @break
       @case(4)
       @foreach($coll1[2] as $pe)
          
          <tr >
          <td  align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll2[2] as $pe)
        
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>  
         </tr>
         
        
          @endforeach
         @break  
      @endswitch
    @endfor
  
</table>

  
  </body>
  </html>
   @foreach($users as $us)
                 <a>Reporte Generado por :  {{$us->name}} </a>
               @endforeach