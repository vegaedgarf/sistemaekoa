<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('materiales_inventario', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion');
            $table->unsignedBigInteger('detalle_id')->nullable(); // Vinculación con el detalle de recepción
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->unsignedBigInteger('id_ubicacion')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->timestamps();

            // Claves Foráneas
            $table->foreign('detalle_id')->references('id')->on('detalle_recepciones')->onDelete('set null');
            $table->foreign('id_categoria')->references('id')->on('cat_categorias');
        });
    }
    public function down() {
        Schema::dropIfExists('materiales_inventario');
    }
};
