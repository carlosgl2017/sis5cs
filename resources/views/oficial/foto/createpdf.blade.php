<html utf8_decode>

<head>

    <table id="mytable"   border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
    <tr>@foreach ($tipocred as $tip)
     <td  width="420px" > <left><small><em><i style="color:#B73451"; >Tipo Credito: {{$tip->tipo_credito}} </i></em></small><br>
      @endforeach 
                                     
                  @foreach ($nombre as $nom)
                  <small> <em><i style="color:#B73451"; >Nombre: {{$nom->nombre}}  {{$nom->ap_paterno}} {{$nom->ap_materno}} </i></em></small>
                    
                    @endforeach <br>
                    <small> <em><i style="color:#B73451"; > Creacion Reporte: {{$now}} </i></em> </small> </td>
                 <td valign="top" align="right"><left><small><em><p style="color:#B73451"; >Cooperativa de Ahorro y Credito Societaria  <br>                                          
                 &nbsp;&nbsp;&quot;San Martin&quot; R.L. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   </p></em></small></td>
                   
                    <td   width="5" heigth="5" valign="top"> <img src="{{public_path('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >
                   
            </td> 
                    
          </tr> 
        
        </table>    
                  
                  
</head>
    <br></br>
<body >
<table width="80%" align="center">
<caption  style="color:#3E3E8B";><pre style="white-space: normal"><ins><font size="3" FACE="times new roman">{{$titulo}}</font> </ins></pre></caption>  
</table>
   <table width="100%" border="0"
     cellspacing="5" cellpadding="5" >
  <br></br>
  @switch($hptam)  
  @case (3) 
   @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
           <tr >
            <td align="center" width ="350px"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="350px" class="img-thumbnail"></td>   
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td align="center" width ="350px" ><img style="position:absolut;" src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="350px" class="img-thumbnail"></td>   
            </tr>  
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          
          <tr>
          <td align="center" width="600px"colspan="2" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="600px" width="600px" class="img-thumbnail"></td>   
           
           </tr> 
           
           
          @endforeach
          @break
       @case(3)
         @break
      @endswitch
    @endfor
  @break
  @case(4)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
        
           <tr>
           
           <td align="center" width ="400px"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
           
      </td>
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          <td align="center" width ="400px" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
            </tr>  
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          <tr>
          <td align="center"  width ="400px" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
           
           
           
          @endforeach
          @break
       @case(3)
       @foreach($coll[$i] as $pe)
          <td align="center" width ="400px"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="400px" width="400px" class="img-thumbnail"></td>   
           
           </tr> 
          
          @endforeach
         @break
      @endswitch
    @endfor
  @break
  @case(5)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
        
           <tr>
           
           <td  align="center" width ="350px"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="350px" class="img-thumbnail"></td>   
           
      </td>
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
        
          <td align="center" width ="350px" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="350px" class="img-thumbnail"></td>   
            </tr>  
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width ="350px" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="350px" class="img-thumbnail"></td>   
          @endforeach
          @break
       @case(3)
       @foreach($coll[$i] as $pe)
          
          <td align="center" width ="350px"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="350px" class="img-thumbnail"></td>   
           
           </tr> 
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          <tr >
          <td align="center" colspan="5"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="350px" width="400px" class="img-thumbnail"></td>  
         </tr>
         
          @endforeach
         @break
        
      @endswitch
    @endfor
  @break
  @case(6)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
        
           <tr>
           
           <td  align="center" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="320px" width="360px" class="img-thumbnail"></td>   
           
      </td>
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td  align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="320px" width="360px" class="img-thumbnail"></td>   
            </tr>  
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="320px" width="360px" class="img-thumbnail"></td>   
           
           
           </div>
          @endforeach
          @break
       @case(3)
       @foreach($coll[$i] as $pe)
         
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="320px" width="360px" class="img-thumbnail"></td>   
           
           </tr> 
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          <tr >
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="320px" width="360px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="320px" width="360px" class="img-thumbnail"></td>  
         </tr>
        
          @endforeach
         @break  
      @endswitch
    @endfor
  @break 
</table>

  @case(7)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
          <table border="1" width= "100%"
            align="center"  cellspacing="3" cellpadding="3"  >
           <tr>
           
           <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
              
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          
          <td width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
           
          </tr> 
           </div>
          @endforeach
          @break
          
       @case(3)
       @foreach($coll[$i] as $pe)
         <tr>
          <td width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
           
           
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          
          <td width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
         </tr>
          @endforeach
         @break  
         @case(6)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" colspan="5"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="430px" width="430px" class="img-thumbnail"></td>  
         </tr>
         
         </table>
          @endforeach
         @break 
      @endswitch
    @endfor
  @break
  @case(8)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
          <table border="0" width="100%" align="center"  cellspacing="3" cellpadding="3">
           <tr>
           
           <td  align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>   
           
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td  align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>   
            </tr>
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>   
           
          
           
          @endforeach
          @break
          
       @case(3)
       @foreach($coll[$i] as $pe)
         
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>   
           
           </tr>
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          <tr>
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>  
         </tr>
          @endforeach
         @break  
         @case(6)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>  
         
          @endforeach
         @break 
         @case(7)
        @foreach($coll[$i] as $pe)
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="320px" class="img-thumbnail"></td>  
           </tr>
          
         </table>
          @endforeach
          
         @break 
      @endswitch
    @endfor
  @break
  @case(9)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
          <br></br>
          <table 
          border="0" width="100%" align="center"  cellspacing="3" cellpadding="3"  >
           <tr>
           
           <td align="center"  width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
           
      </td>
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td  align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
            
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          
          <td align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
           
          </tr>
           
          @endforeach
          @break
          
       @case(3)
       @foreach($coll[$i] as $pe)
           <tr>
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
           
           
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
         </tr>
          @endforeach
         @break  
         @case(6)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
         
          @endforeach
         @break 
         @case(7)
        @foreach($coll[$i] as $pe)
          
          <td  align="center" whidth="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
           
          @endforeach
         @break 
         @case(8)
        @foreach($coll[$i] as $pe)
          
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>  
           </tr>
</table>
          @endforeach
         @break 
      @endswitch
    @endfor
  @break
  @case(10)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
          <table width="100%" border="0"
            align="center"  cellspacing="3" cellpadding="3"  >
           <tr>
           
           <td  align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
      </td>
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
            
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          
          <td align="center" width="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
          </tr>
           
          @endforeach
          @break
          
       @case(3)
       @foreach($coll[$i] as $pe)
           <tr>
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
           
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         </tr>
          @endforeach
         @break  
         @case(6)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         
          @endforeach
         @break 
         @case(7)
        @foreach($coll[$i] as $pe)
          
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           
          @endforeach
         @break 
         @case(8)
        @foreach($coll[$i] as $pe)
          
          <td align="center" width="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           </tr>
          @endforeach
         @break 
         @case(9)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" colspan="3" width="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           </tr>
          
         </table>
          @endforeach
         @break
      @endswitch
    @endfor
  @break
  @case(11)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
          <table  width="100%" border="0"
            align="center"  cellspacing="3" cellpadding="3"  >
           <tr>
           
           <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
      </td>
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
            
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          
          <td align="center" width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
          </tr>
           
          @endforeach
          @break
          
       @case(3)
       @foreach($coll[$i] as $pe)
           <tr>
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
           
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         </tr>
          @endforeach
         @break  
         @case(6)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         
          @endforeach
         @break 
         @case(7)
        @foreach($coll[$i] as $pe)
          
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           
          @endforeach
         @break 
         @case(8)
        @foreach($coll[$i] as $pe)
          
          <td align="center" width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           </tr>
          @endforeach
         @break 
         @case(9)
        @foreach($coll[$i] as $pe)
          <tr>
          <td align="center" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           
          @endforeach
         @break
         @case(10)
        @foreach($coll[$i] as $pe)
          <td></td>
          <td align="center" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           </tr>
          
          </table>
          @endforeach
         @break
      @endswitch
    @endfor
  @break
  
  @case(12)
  @for($i=0 ;$i<$hptam;$i++ )
      @switch($i)
        @case(0)
          @foreach($coll[$i] as $pe)
          <table border="0" width="100%" align="center"
            align="right"  cellspacing="3" cellpadding="3"  >
           <tr>
           <td  width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
      
           
          @endforeach
             @break
             
        @case(1)
          @foreach($coll[$i] as $pe)
          
          <td width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
            
          @endforeach
            @break
          
        @case(2)
          @foreach($coll[$i] as $pe)
          
          <td width ="50%" ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
          </tr>
           
          @endforeach
          @break
          
       @case(3)
       @foreach($coll[$i] as $pe)
           <tr>
          <td width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>   
           
           
        
          @endforeach
         @break
       @case(4)
       @foreach($coll[$i] as $pe)
          
          
          <td width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         
          @endforeach
         @break
        @case(5)
        @foreach($coll[$i] as $pe)
          <td width ="50%"><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         </tr>
          @endforeach
         @break  
         @case(6)
        @foreach($coll[$i] as $pe)
          <tr>
          <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
         
          @endforeach
         @break 
         @case(7)
        @foreach($coll[$i] as $pe)
          
          <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           
          @endforeach
         @break 
         @case(8)
        @foreach($coll[$i] as $pe)
          
          <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           </tr>
          @endforeach
         @break 
         @case(9)
        @foreach($coll[$i] as $pe)
          <tr>
          <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           
          @endforeach
         @break
         @case(10)
        @foreach($coll[$i] as $pe)
          
          <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           
          @endforeach
         @break
         @case(11)
        @foreach($coll[$i] as $pe)
          
          <td ><img src="{{public_path('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="270px" width="270px" class="img-thumbnail"></td>  
           </tr>
         
          </table>
          @endforeach
         @break
      @endswitch
    @endfor
  @break
  @endswitch
  
 
    </table>
   
    

</body>

 
</html>
@foreach($users as $us)
                 <a>Reporte Generado por :  {{$us->name}} </a>
@endforeach

