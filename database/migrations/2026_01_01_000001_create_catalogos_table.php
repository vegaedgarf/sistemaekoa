<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tablas = ['cat_categorias', 'cat_marcas', 'cat_estados', 'cat_ubicaciones', 'cat_tareas', 'cat_sistemas_operativos'];
        foreach ($tablas as $tabla) {
            Schema::create($tabla, function (Blueprint $table) use ($tabla) {
                $table->id();
                $table->string('nombre');
                if ($tabla === 'cat_categorias') {
                    $table->char('identificador_letra', 1)->unique()->nullable();
                }
                $table->timestamps();
            });
        }
    }
    public function down(): void {
        $tablas = ['cat_sistemas_operativos', 'cat_tareas', 'cat_ubicaciones', 'cat_estados', 'cat_marcas', 'cat_categorias'];
        foreach ($tablas as $tabla) {
            Schema::dropIfExists($tabla);
        }
    }
};
