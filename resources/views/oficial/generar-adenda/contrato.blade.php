<!DOCTYPE html>
<html lang="es">
<?php
function getMonth($meses)
{
    switch ($meses) {
        case 1:
            return "enero";
            break;
        case 2:
            return "febrero";
            break;
        case 3:
            return "marzo";
            break;
        case 4:
            return "abril";
            break;
        case 5:
            return "mayo";
            break;
        case 6:
            return "junio";
            break;
        case 7:
            return "julio";
            break;
        case 8:
            return "agosto";
            break;
        case 9:
            return "septiembre";
            break;
        case 10:
            return "octubre";
            break;
        case 11:
            return "novimbre";
            break;
        case 12:
            return "diciembre";
            break;
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <style>
        body {
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 30px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12;
            text-align: justify;
        }


        .titulo {
            font-weight: bold;
            text-align: center;

        }
    </style>
</head>

<body>



    <div id="titulo">
        <p class="titulo">DOCUMENTO PRIVADO</p>
    </div>

    <div id="contenido">
        <p class="parrafo">Conste por el presente contrato modificatorio a un contrato de reprogramación por ampliación de plazo y otras modificaciones de un contrato de préstamo de dinero, que podrá ser elevado a la categoría de documento público a solicitud de cualquiera de las partes que lo suscriben, al tenor y contenido de las siguientes cláusulas:</p>
        <p class="parrafo"><strong>PRIMERA: (Partes).-</strong> Intervienen en la celebración del presente contrato:</p>
        <p class="parrafo"><strong>1.1. LA COOPERATIVA DE AHORRO Y CRÉDITO SOCIETARIA “SAN MARTÍN” R.L.</strong>, institución legalmente establecida, con Personería Jurídica reconocida mediante Resolución de Consejo N° 00535 de fecha 7 de octubre de 1966 expedida por la Dirección Nacional de Cooperativas, con Resolución Administrativa H-2ª FASE-Nº 188/2017 de fecha 4 de diciembre de 2017 expedida por la Autoridad de Fiscalización y Control de Cooperativas AFCOOP, con Número de Identificación Tributaria (NIT) 1011257021, con Licencia de Funcionamiento expedido por la Autoridad de Supervisión del Sistema Financiero “A.S.F.I.” mediante Resolución N° 019/2019 de fecha 22 de octubre de 2019, con domicilio en la calle Topater N° 5 de la ciudad de Potosí, representado legalmente por el <strong> Lic. HERNAN ADALID BARRIENTOS ENRIQUEZ</strong>, con documento de identificación N° 1323925 Pt., conforme al Testimonio de Poder N° 194/2019 de fecha 15 de abril de 2019, extendido por ante la Notaria de Fe Pública N° 8 a cargo de la Abog. Shirley Quiñones Ortiz, en adelante Entidad de Intermediación Financiera (EIF) o ACREEDOR.</p>
        <p class="parrafo"><strong>1.2.</strong> El (La) señor(a) <strong>{{$prestatario->dnombre}}</strong>, con documento de identificación N° {{$prestatario->dci}}, mayor de edad y hábil por derecho, con estado civil {{$prestatario->destadocivil}}, con domicilio en {{$prestatario->ddireccion}}, en adelante DEUDOR.</p>
        @if($prestatario->existec===1)
        <p class="parrafo"><strong>1.3. </strong>El (La) señor(a) <strong>{{$prestatario->cnombre}}</strong>, con documento de identificación N° {{$prestatario->cci}}, mayor de edad y hábil por derecho, con estado civil {{$prestatario->cestadocivil}}, con domicilio en {{$prestatario->cdireccion}}, en adelante CO-DEUDOR.</p>
        @endif

        @if($prestatario->moneda=="MN")
        <p class="parrafo"><strong>SEGUNDA: (ANTECEDENTES)</strong>.- Mediante Contrato de Préstamo de Dinero de fecha {{$fecha_contrato->day}} de {{getMonth($fecha_contrato->month)}} de {{$fecha->year}}, debidamente reconocida en sus firmas y rúbricas, por ante la Notaria de Fe Pública N° {{$prestatario->nnotaria}} a cargo de la Notaria de Fe Pública N° {{$prestatario->nnotaria}}, a cargo de (la) Abog. {{$prestatario->nombreaboga}}, La EIF, concedió en favor del (la) (los) DEUDOR (ES), un préstamo de dinero identificado como la operación crediticia N° {{$prestatario->nroprestamo}}, por la suma de <strong>{{$literal}}</strong>Este préstamo se concedió de acuerdo al plazo, términos, condiciones y garantías estipuladas en dicho contrato.</p>
        @else
        <p class="parrafo"><strong>SEGUNDA: (ANTECEDENTES)</strong>.- Mediante Contrato de Préstamo de Dinero de fecha {{$fecha_contrato->day}} de {{getMonth($fecha_contrato->month)}} de {{$fecha->year}}, debidamente reconocida en sus firmas y rúbricas, por ante la Notaria de Fe Pública N° {{$prestatario->nnotaria}} a cargo de la Notaria de Fe Pública N° {{$prestatario->nnotaria}}, a cargo de (la) Abog. {{$prestatario->nombreaboga}}, La EIF, concedió en favor del (la) (los) DEUDOR (ES), un préstamo de dinero identificado como la operación crediticia N° {{$prestatario->nroprestamo}}, por la suma de <strong>{{$literal}}</strong> Este préstamo se concedió de acuerdo al plazo, términos, condiciones y garantías estipuladas en dicho contrato.</p>
        @endif

        <p class="parrafo"><strong>TERCERA: (REPROGRAMACIÓN POR AMPLIACIÓN DE PLAZO)</strong>.- La EIF y el (la) (los) DEUDOR(ES), de manera libre y voluntaria convienen en ampliar el plazo de EL PRÉSTAMO en ({{$prestatario->cuotasadicionales}}) CUOTAS adicionales al plazo originalmente convenido en EL PRÉSTAMO. En ese entendido el plazo del prestamo será de ({{$prestatario->ncuotasoriginal+$prestatario->cuotasadicionales}}) CUOTAS. Esta ampliación comprende la prórroga y el periodo de gracia establecidos en este contrato.</p>
        <p class="parrafo">El plazo total de EL PRÉSTAMO, incluyendo la ampliación que se conviene en esta cláusula, se computará a partir de la fecha del desembolso efectuado.</p>
        <p class="parrafo"><strong>CUARTA: (DIFERIMIENTO)</strong>.- El (la) (los) DEUDOR(ES) reconocen que en cumplimiento al diferimiento dispuesto en virtud a la normativa emitida por el Estado (Ley N° 1294, modificación y reglamentaciones), aplicable al pago de las amortizaciones por los meses de marzo a diciembre de 2020, las amortizaciones diferidas por dicho periodo deberán ser pagadas en {{$prestatario->namortizaciones}} amortizaciones mensuales, que comprenderán capital, interés y primas de seguros, a partir del vencimiento de la ampliación del plazo de EL PRÉSTAMO convenido en la anterior cláusula, conforme a la Tabla de Amortización que se generará por efecto de este contrato.</p>
        <p class="parrafo">Se deja expresa constancia que la EIF no podrá agregar las sumas de dinero adeudadas por intereses y las primas de seguros al capital adeudado y menos aún aplicarles y/o cobrar a LOS CO-DEUDORES ningún otro interés, otros recargos, intereses extraordinarios o adicionales, que no sea el interés originalmente convenido en EL PRÉSTAMO.</p>
        @if($prestatario->moneda=="MN")
        <p class="parrafo"><strong>QUINTA: (RECONOCIMIENTO DE OBLIGACIONES)</strong>.- A tiempo de suscribir el presente contrato el (la) (los) DEUDOR (ES) sin que exista presión, dolo, violencia o cualesquier vicio que pudiere invalidar el consentimiento , declaran que adeudan y reconocen que adeudan a la EIF el saldo a capital que a la fecha de este contrato ascienden a la suma de <strong>{{number_format($prestatario->montodiferido,2,',', '.')}} Bs.</strong>, reconociendo igualmente que también adeudan los intereses y las primas de seguro que corresponden a las amortizaciones deferidas.</p>
        @else
        <p class="parrafo"><strong>QUINTA: (RECONOCIMIENTO DE OBLIGACIONES)</strong>.- A tiempo de suscribir el presente contrato el (la) (los) DEUDOR (ES) sin que exista presión, dolo, violencia o cualesquier vicio que pudiere invalidar el consentimiento , declaran que adeudan y reconocen que adeudan a la EIF el saldo a capital que a la fecha de este contrato ascienden a la suma de <strong>{{number_format($prestatario->montodiferido,2,',', '.')}} $us.</strong>, reconociendo igualmente que también adeudan los intereses y las primas de seguro que corresponden a las amortizaciones deferidas.</p>
        @endif
        <p class="parrafo"><strong>SEXTA: (GRACIA)</strong>.- La EIF concede un periodo de gracia para el pago de las amortizaciones por seis (6) meses, computable a partir de la siguiente amortización a la fecha de suscripción del presente contrato.</p>
        <p class="parrafo">Las amortizaciones a capital e intereses, que correspondan tanto a la prórroga como al periodo de gracia, serán prorrateadas para su correspondiente pago en las siguientes amortizaciones, computables a partir del vencimiento del periodo de gracia convenido en la presente cláusula.</p>
        <p class="parrafo">Las primas de seguros correspondientes a la prórroga y periodo de gracia, serán pagadas en ({{$prestatario->amortiza2}}) AMORTIZACIONES MENSUALES, a partir de la cuota con vencimiento en {{$prestatario->mesiniciopago}} de 2021.</p>
        <p class="parrafo"><strong>SÉPTIMA: (INCUMPLIMIENTO EN EL PAGO DE AMORTIZACIONES Y OTROS)</strong>.- El incumplimiento en el pago de cualquiera de las amortizaciones establecidas en la Tabla de Amortización o del pago de los intereses y primas de seguro diferidas, determinará que el (la) (los) DEUDOR(ES) queden constituidos en mora sin necesidad de ningún tipo de formalidad o requerimiento de mora previo, judicial, extrajudicial, por el solo vencimiento del plazo establecido para su cumplimiento y que las obligaciones de pago de el (la) (los) DEUDOR(ES) sean exigibles en su totalidad, sin importar que existan amortizaciones pendientes de vencimiento, reputándose EL PRÉSTAMO para el efecto , como de plazo vencido y con fuerza de ejecución suficiente.</p>
        <p class="parrafo">Cualquier espera que la EIF admitiera en favor de el (la) los) DEUDOR(ES), al vencimiento de cualquiera de las amortizaciones convenidas, no afectará la exigibilidad del total de la obligación conforme lo anterior y no importará prórroga del plazo principal, ni renovación del presente contrato, sino una simple tolerancia que en nada afectará o modificará los derechos de la EIF para exigir el pago total de EL PRÉSTAMO, sus intereses, primas de seguro y otros, ni tampoco alterará la fuerza de ejecución de EL PRÉSTAMO y del presente contrato. </p>
        <p class="parrafo"><strong>OCTAVA: (RECONOCIMIENTO Y VIGENCIA DE GARANTÍAS)</strong>.- El (la (los) DEUDOR(ES) de modo expreso reconoce(n) todas y cada una de las obligaciones emergentes, términos y estipulaciones de EL PRÉSTAMO, en su íntegro tenor y en consecuencia le reconoce plena validez y eficacia jurídica, declarando que todas las garantías constituidas a favor de la EIF en EL PRÉSTAMO se mantienen plenamente vigentes, sin que este contrato constituya novación ni causal alguna de extinción de EL PRÉSTAMO, el cual mantiene toda su vigencia hasta su pago total y de manera especial la garantía convenida, que se mantiene(n) subsistente(s) y vigente(s) con pleno valor legal y con todas las preferencias, privilegios, orden y derechos correspondientes. </p>
        <p class="parrafo"><strong>NOVENA: (SUBSISTENCIA DE OBLIGACIONES)</strong>.- Cualquier eliminación o alteración de registros y/o datos de la presente operación crediticia en los sistemas informáticos de la EIF de ninguna manera significará la extinción de EL PRÉSTAMO por lo que el único modo de su extinción es su debido cumplimiento y pago en la forma y plazo convenidos en EL PRÉSTAMO y en este contrato.</p>
        <p class="parrafo"><strong>DECIMA: (CALIDAD DEL DOCUMENTO)</strong>.- El presente documento surtirá efectos de ley entre las partes al amparo de lo establecido por los arts. 519 y 1297 del Código Civil y el Art. 147 del Código Procesal Civil.</p>
        <p class="parrafo"><strong>DÉCIMA PRIMERA.- (CONFORMIDAD)</strong>.- La Entidad de Intermediación Financiera (EIF), el(los) DEUDOR(ES) dan su plena conformidad con todas y cada una de las cláusulas del presente contrato, firmando al pie del presente documento.</p>
        <p class="parrafo"><strong>Potosí, {{$fecha->day}} de {{getMonth($fecha->month)}} de {{$fecha->year}} </strong></p>
        <br>
        <br>
        <br>
        <table style="text-align: center; margin:auto;  line-height: 1.6px; ">
            <tr>
                <td>
                    <p>____________________________________________</p>
                    <p>Lic. HERNAN ADALID BARRIENTOS ENRIQUEZ</p>
                    <p>C.I. N° 1323925 Pt.</p>
                    <p>Gerente General de la Cooperativa de Ahorro y Crédito</p>
                    <p>Societaria “San Martín” R.L.</p>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        @if($prestatario->existec==0)
        <table style="text-align: center; margin:auto;  line-height: 1.6px; ">
            <tr>
                <td>
                    <p>______________________________</p>
                    <p>{{$prestatario->dnombre}}</p>
                    <p>{{$prestatario->dci}}</p>
                </td>
            </tr>
        </table>
        @else
        <table style="text-align: center; margin:auto;  line-height: 1.6px; ">
            <tr>
                <td>
                    <p>____________________________</p>
                    <p>{{$prestatario->dnombre}}</p>
                    <p>{{$prestatario->dci}}</p>
                </td>
            </tr>
            <br>
            <br>
            <br>
            <tr>
                <td>
                    <p>______________________________</p>
                    <p>{{$prestatario->cnombre}}</p>
                    <p>{{$prestatario->cci}}</p>
                </td>
            </tr>
        </table>
        @endif

    </div>


    <!-- <footer>
        <img src="web/img/pie.png" width="100%" height="100%">
    </footer> -->

</body>


</html>