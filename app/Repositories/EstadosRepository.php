<?php

namespace sis5cs\Repositories;

use sis5cs\Seguimiento;
use sis5cs\Credito;

class EstadosRepository
{
  public function estado1($id)
  {
    //Oficial de crédito
    $seguimiento = Seguimiento::where('id_credito', $id)->where('id_area',2)->orderBy('id_seguimiento', 'ASC')->get();
    $first = $seguimiento->first()->id_area;
    $completado=$seguimiento->first()->completado;
    if ($first == 2 && $completado==true ) {
      return true;
    } else {
      return false;
    }
  }
  public function estado2($id)
  {
    //Encargado de créditos
    $seguimiento = Seguimiento::where('id_credito', $id)->where('id_area',3)->orderBy('id_seguimiento', 'ASC')->get();
    $first = $seguimiento->first()->id_area;
    $completado=$seguimiento->first()->completado;
    if ($first == 3 && $completado==true ) {
      return true;
    } else {
      return false;
    }
  }
  public function estado3($id)
  {
    //Encargada de riesgos
    $seguimiento = Seguimiento::where('id_credito', $id)->where('id_area',4)->orderBy('id_seguimiento', 'ASC')->get();
    $first = $seguimiento->first()->id_area;
    $completado=$seguimiento->first()->completado;
    if ($first == 4 && $completado==true ) {
      return true;
    } else {
      return false;
    }
  }
  public function estado4($id)
  {
    //Encargado de operaciones
    $seguimiento = Seguimiento::where('id_credito', $id)->where('id_area',5)->orderBy('id_seguimiento', 'ASC')->get();
    $first = $seguimiento->first()->id_area;
    $completado=$seguimiento->first()->completado;
    if ($first == 5 && $completado==true ) {
      return true;
    } else {
      return false;
    }
  }
  public function estado5($id)
  {
    //Asesoria
    $seguimiento = Seguimiento::where('id_credito', $id)->where('id_area',7)->orderBy('id_seguimiento', 'ASC')->get();
    $first = $seguimiento->first()->id_area;
    $completado=$seguimiento->first()->completado;
    if ($first ==7  && $completado==true ) {
      return true;
    } else {
      return false;
    }
  }

  public function desembolsado($id)
  {
    //desembolsado
    $credito = Credito::where('id_credito', $id)->get();  
    if ($credito->desembolsado==true) {
      return true;
    } else {
      return false;
    }
  }
}
