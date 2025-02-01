<?php

namespace sis5cs\Http\Controllers\Oficial;

use Illuminate\Http\Request;
use sis5cs\Http\Controllers\Controller;
use DB;
use sis5cs\Persona;

class EjecutarCopiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $creditos = DB::table('credito')
            ->join('persona', 'credito.id_persona', '=', 'persona.id_persona')
            ->select('credito.*', 'persona.*')
            ->get();
        return view('oficial.ejecutar_copia.index')->with(compact('creditos'));
    }


    public function ejecutar($id_persona,$id_credito)
    {
        if(isset($id_persona) && isset($id_credito)){
            flash()->error('No puede estar vacio');
            return redirect('oficial/copiar/');
        }
        else{

            alert()->info('Info', 'exelente')->showConfirmButton();
            return redirect('oficial/copiar/');
        }
    }
}
