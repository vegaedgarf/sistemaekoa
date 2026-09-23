<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CatalogoController extends Controller
{
    public function show($tipo)
    {
        // Mapeo seguro de tablas de catálogos
        $map = [
            'categorias' => 'cat_categorias',
            'marcas' => 'cat_marcas',
            'estados' => 'cat_estados',
            'ubicaciones' => 'cat_ubicaciones',
            'tareas' => 'cat_tareas',
            'sistemas-operativos' => 'cat_sistemas_operativos',
        ];

        if (!array_key_exists($tipo, $map)) {
            return response()->json(['error' => 'Catálogo no encontrado'], 404);
        }

        $data = DB::table($map[$tipo])->get();

        return response()->json([
            'catalogo' => $tipo,
            'data' => $data
        ]);
    }
}