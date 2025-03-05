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
        // Tablas y sus respectivas claves primarias
        $tablas = [
            'reporte_buro' => 'id_reporte_buro',
            'deposito_bancario' => 'id_dbancario',
            'inversiones_financieras' => 'id_inversion_financiera',
            'cuentas_documentos_cobrar' => 'id_cuentas_docu',
            'inventario_mercaderia' => 'id_imercaderia',
            'maquinaria_equipo' => 'id_maquinaria_equi',
            'bienes_hogar' => 'id_bien_hogar',
            'inmueble' => 'id_inmueble',
            'vehiculo' => 'id_vehiculo',
            'efectivos_caja' => 'id_efectivos_caja',
            'otros_activos' => 'id_otros_activos',
            'prestamo_bancario' => 'id_pbancario',
            'cuentas_por_pagar' => 'id_cppagar',
            'gastos_familiares' => 'id_gastos_familiares',
            'gastos_operativos_comercializacion' => 'id_gastos_operativos',
            'mano_obra_mensual' => 'id_mano_obra',
            'ingreso_mensual' => 'id_ingreso_mensual',
            'venta_comercializacion_productos' => 'id_venta_comercializacion',
            'capacidad_pago' => 'id_capacidad_pago',
            'croquis' => 'id_croquis',
            'codeudor' => 'id_codeudor',
            'ventas' => 'id_ventas',
            'garantia' => 'id_garantia',
            // Agrega aquí las 18 tablas restantes con sus claves primarias respectivas
        ];
        $datosAnteriores = DB::table('reprogramados')
            ->where('id_persona', $id_persona)
            ->where('id_credito_rep', $id_credito)
            ->first();
        // Obtener los id_persona y id_credito anteriores
        $idPersonaAnterior = $datosAnteriores->id_persona;
        $idCreditoAnterior = $datosAnteriores->id_credito;

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            foreach ($tablas as $tabla => $clavePrimaria) {
                $this->duplicarDatosDeTabla($tabla, $clavePrimaria, $idCreditoAnterior, $idPersonaAnterior, $id_credito, $id_persona);
            }

            // Confirmar los cambios si todo fue exitoso
            DB::commit();
            flash()->addSuccess('Se realizo la copia correctamente.');
            return redirect()->route('ejecutar_copia');

        } catch (\Exception $e) {
            // Deshacer los cambios en caso de error
            DB::rollBack();
            flash()->addError("Ocurrió un error: ". $e->getMessage());
            return redirect()->route('ejecutar_copia');
        }

    }

    function duplicarDatosDeTabla($tabla, $clavePrimaria, $oldCreditoId, $oldPersonaId, $newCreditoId, $newPersonaId)
    {
        // Obtener los datos de la tabla proporcionada
        $datos = DB::table($tabla)
            ->where('id_credito', $oldCreditoId)
            ->where('id_persona', $oldPersonaId)
            ->get();

        // Preparar nuevos datos para insertar sin las claves incrementales
        $nuevosDatos = $datos->map(function ($dato) use ($clavePrimaria, $newCreditoId, $newPersonaId) {
            $registro = (array) $dato;  // Convertir el objeto a array para manipulación

            // Eliminar la clave primaria especificada para esta tabla
            if (isset($registro[$clavePrimaria])) {
                unset($registro[$clavePrimaria]);
            }

            // Actualizar las columnas con los nuevos valores
            $registro['id_credito'] = $newCreditoId;  // Nuevo id_credito
            $registro['id_persona'] = $newPersonaId;  // Nuevo id_persona

            return $registro;
        })->toArray();

        // Insertar los datos nuevos
        if (!empty($nuevosDatos)) {
            DB::table($tabla)->insert($nuevosDatos);
        }
    }


}
