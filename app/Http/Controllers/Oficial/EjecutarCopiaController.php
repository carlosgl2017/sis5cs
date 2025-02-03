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


    public function ejecutar($id_persona, $id_credito)
    {

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // 1. Obtener los datos anteriores de la tabla 'datos_anteriores'
            $datosAnteriores = DB::table('reprogramados')
                ->where('id_persona', $id_persona)
                ->where('id_credito_rep', $id_credito)
                ->first();
            if (!$datosAnteriores) {
                alert()->info('Info', 'Datos anteriores no encontrados')->showConfirmButton();
                return redirect('oficial/ejecutar_copia/');
            }

            // Obtener los id_persona y id_credito anteriores
            $idPersonaAnterior = $datosAnteriores->id_persona;
            $idCreditoAnterior = $datosAnteriores->id_credito_rep;


            // 2. Obtener los nuevos id_persona y id_credito desde la tabla 'credito'
            //$nuevoCredito = DB::table('credito')
            //    ->where('id_persona', $idPersona)
            //    ->where('id_credito', $idCredito)
            //    ->first();

            //if (!$nuevoCredito) {
            //    return response()->json(['error' => 'Nuevo crédito no encontrado'], 404);
            //}

            // Obtener los nuevos id_persona y id_credito
            //$nuevoIdPersona = $nuevoCredito->id_persona;
            // $nuevoIdCredito = $nuevoCredito->id_credito;

            // 3. Lista de tablas a copiar y sus claves primarias correspondientes
            $tablas = [
                'reporte_buro' => 'id_reporte_buro',
                'deposito_bancario' => 'id_dbancario',
                'inversiones_financieras' => 'id_inversion_financiera'
            ];

            // 4. Copiar los datos para cada tabla (actualizando si ya existen)
            foreach ($tablas as $tabla => $clavePrimaria) {
                $this->copiarTablaYActualizarSiExiste($tabla, $clavePrimaria, $idPersonaAnterior, $idCreditoAnterior, $id_persona, $id_credito);
            }

            // Confirmar transacción
            DB::commit();
            return redirect('oficial/ejecutar_copia/');
        } catch (\Exception $e) {
            // En caso de error, revertir transacción
            DB::rollBack();
            alert()->info('Info', 'Error')->showConfirmButton();
            return redirect('oficial/ejecutar_copia/');
        }
    }

    private function copiarTablaYActualizarSiExiste($tabla, $clavePrimaria, $idPersonaAnterior, $idCreditoAnterior, $nuevoIdPersona, $nuevoIdCredito)
    {
        // Obtener las columnas de la tabla
        $columnas = DB::getSchemaBuilder()->getColumnListing($tabla);

        // Excluir la columna de clave primaria específica (por ejemplo, 'id_prestamos', 'id_gastosfamiliares', etc.)
        $columnas = array_diff($columnas, [$clavePrimaria]);

        // Obtener los registros de la tabla de acuerdo a los valores anteriores
        $registros = DB::table($tabla)
            ->where('id_persona', $idPersonaAnterior)
            ->where('id_credito', $idCreditoAnterior)
            ->get($columnas);

        // Recorrer los registros y actualizarlos o insertarlos
        foreach ($registros as $registro) {
            // Convertimos el registro a un array
            $datosInsertar = (array)$registro;
            $datosInsertar['id_persona'] = $nuevoIdPersona; // Asignar el nuevo id_persona
            $datosInsertar['id_credito'] = $nuevoIdCredito; // Asignar el nuevo id_credito

            // Verificar si el registro ya existe en la tabla con el nuevo id_persona y id_credito
            $existe = DB::table($tabla)
                ->where('id_persona', $nuevoIdPersona)
                ->where('id_credito', $nuevoIdCredito)
                ->exists();

            if ($existe) {
                // Si el registro existe, lo actualizamos
                DB::table($tabla)
                    ->where('id_persona', $nuevoIdPersona)
                    ->where('id_credito', $nuevoIdCredito)
                    ->update($datosInsertar);
            } else {
                // Si no existe, insertamos un nuevo registro
                DB::table($tabla)->insert($datosInsertar);
            }
        }
    }

}
