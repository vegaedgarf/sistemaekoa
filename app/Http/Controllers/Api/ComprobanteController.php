<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ComprobanteRecepcion;
use App\Models\DetalleRecepcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprobanteController extends Controller
{
    /**
     * Almacena un nuevo comprobante de recepción y sus líneas de detalle (RF-02).
     */
public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'cedente' => 'required|string|max:255', // Validamos lo que envía el JS
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

            // 1. Crear el registro maestro
           $comprobante = ComprobanteRecepcion::create([
                'fecha' => $validated['fecha'],
                'cedente' => $validated['cedente'], // Cambiamos la clave a 'cedente'
                'peso_total_estimado' => $validated['peso_total_estimado'] ?? null,
                'firmas' => $validated['firmas'] ?? null,
            ]);

            // 2. Registrar las líneas de detalle asociadas
        foreach ($validated['detalles'] as $item) {
                DetalleRecepcion::create([
                    'comprobante_id' => $comprobante->getKey(), // Método nativo seguro para obtener el ID recién creado
                    'id_categoria' => $item['id_categoria'],
                    'cantidad_recibida' => $item['cantidad_recibida'],
                    'peso_subtotal' => $item['peso_subtotal'] ?? null,
                    'requiere_inventario' => $item['requiere_inventario'] ?? true,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Comprobante de recepción registrado con éxito.',
                'data' => $comprobante->load('detalles.categoria')
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