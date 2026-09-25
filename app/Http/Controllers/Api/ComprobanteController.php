<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ComprobanteRecepcion;
use App\Models\DetalleRecepcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprobanteController extends Controller
{
    public function store(Request $request)
    {
        // Actualizamos la validación reemplazando 'cedente' por los campos desglosados
        $validated = $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'nullable|integer',
            'cuit' => 'nullable|string|max:20',
            'mail_principal' => 'nullable|email|max:255',
            'mail_secundario' => 'nullable|email|max:255',
            'peso_total_estimado' => 'nullable|numeric',
            'firmas' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_categoria' => 'required|exists:cat_categorias,id',
            'detalles.*.cantidad_recibida' => 'required|integer|min:1',
            'detalles.*.peso_subtotal' => 'nullable|numeric',
            'detalles.*.requiere_inventario' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // 1. Obtener el último número registrado y sumar 1 (o iniciar en 1 si está vacío)
            $ultimoNro = ComprobanteRecepcion::max('nro_comprobante');
            $nuevoNro = $ultimoNro ? $ultimoNro + 1 : 1;

            // 2. Insertar usando el número secuencial entero y los nuevos campos
            $comprobante = ComprobanteRecepcion::create([
                'nro_comprobante' => $nuevoNro,
                'fecha' => $validated['fecha'],
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'dni' => $validated['dni'] ?? null,
                'cuit' => $validated['cuit'] ?? null,
                'mail_principal' => $validated['mail_principal'] ?? null,
                'mail_secundario' => $validated['mail_secundario'] ?? null,
                'peso_total_estimado' => $validated['peso_total_estimado'] ?? null,
                'firmas' => $validated['firmas'] ?? null,
            ]);

            foreach ($validated['detalles'] as $item) {
                DetalleRecepcion::create([
                    'comprobante_id' => $comprobante->id, 
                    'id_categoria' => $item['id_categoria'],
                    'cantidad_recibida' => $item['cantidad_recibida'],
                    'peso_subtotal' => $item['peso_subtotal'] ?? null,
                    'requiere_inventario' => $item['requiere_inventario'] ?? true,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Comprobante de recepción registrado con éxito.',
                'data' => $comprobante->load('detalles')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Ocurrió un error al registrar el comprobante.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}