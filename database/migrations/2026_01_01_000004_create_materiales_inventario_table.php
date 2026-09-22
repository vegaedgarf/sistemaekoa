<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('materiales_inventario', function (Blueprint $table) {
            $table->string('id_inventario')->primary(); // Ej: 1206/A00001
            $table->string('numero_comprobante');
            $table->unsignedBigInteger('id_detalle')->nullable(); // Vinculación con el detalle de recepción
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->unsignedBigInteger('id_ubicacion')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->timestamps();

            // Claves Foráneas
            $table->foreign('numero_comprobante')->references('numero_comprobante')->on('comprobantes_recepcion');
            $table->foreign('id_detalle')->references('id_detalle')->on('detalle_recepciones')->onDelete('set null');
            $table->foreign('id_categoria')->references('id')->on('cat_categorias');
            // Nota: Se asume que las tablas cat_estados y cat_ubicaciones se crearán en la migración de catálogos
        });
    }
    public function down() {
        Schema::dropIfExists('materiales_inventario');
    }
};
