<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 0px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7;
            text-align: justify;
        }

        .titulo {
            font-weight: bold;
            text-align: center;
        }
        .footer-color{
            background:#FBFAF8;
            text-align: center;
            font-weight: bold;
        }
        .logo{
            height: 50;
            width: 50;
        }
    </style>
</head>

<body>
    <div>
        <img class="logo" src="images/logoOficial.png" >
    </div>

    <div id="titulo">
        <p class="titulo">REPORTE DEL SEGUIMIENTO DEL CRÉDITO</p>
    </div>

    <div>
        <table>
            <tr>
                <td><strong> Fecha del reporte</strong></td>
                <td>{{$date}}</td>
            </tr>
            <tr>
                <td><strong> Titular del crédito</strong></td>
                <td>{{session('id_persona_oficial')}}</td>
            </tr>
        </table>
    </div>

    <div id="contenido">
        <table border="1" style="overflow-x: auto">
            <thead style="background-color:#2E86AB; color:white">
                <tr>
                    <th>N°</th>
                    <th>Fecha inicio Atención</th>
                    <th>Fecha Fin de Atención</th>
                    <th>Tiempo de atención</th>
                    <th>Funcionario actual</th>
                    <th>Área actual</th>
                    <th>Usuario destino</th>
                    <th>Área destino</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($seguimiento as $se)
                <tr>
                    <td>{{$se->id_seguimiento}}</td>
                    <td>{{$se->fecha_inicio}}</td>
                    <td>{{$se->fecha_fin}}</td>
                    <?php $cadena = \Carbon\Carbon::parse($se->fecha_inicio)->diffForHumans(\Carbon\Carbon::parse($se->fecha_fin)); ?>
                    <td>{{substr($cadena, 0, strpos($cadena, "antes"))}}</td>
                    <td>{{$se->name}}</td>
                    <td>{{$se->area}}</td>
                    <td>
                        @foreach ($usuarios as $u)
                        @if($u->id_users==$se->usuario_destino)
                        {{$u->name}}
                        @endif
                        @endforeach
                    </td>

                    <td>
                        @foreach ($areas as $a)
                        @if($a->id_area==$se->area_destino)
                        {{$a->area}}
                        @endif
                        @endforeach
                    </td>
                    <td>{{$se->observaciones}}</td>
                </tr>
           
                @endforeach
                <tr>
                    <td class="footer-color" colspan="3">Tiempo total transcurrido</td>
                    <?php $cadena1= \Carbon\Carbon::parse($primer_registro)->diffForHumans(\Carbon\Carbon::parse($ultimo));?>
                    <td class="footer-color">{{substr($cadena1, 0, strpos($cadena1, "antes"))}}</td>
                    <td class="footer-color" colspan="6"></td>
                </tr>
            </tbody>

        </table>

    </div>


    <!-- <footer>
        <img src="web/img/pie.png" width="100%" height="100%">
    </footer> -->
</body>
</html>