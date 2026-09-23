<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('detalle_recepciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion')->onDelete('cascade');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('cantidad_recibida');
            $table->decimal('peso_subtotal', 8, 2)->nullable();
            $table->boolean('requiere_inventario')->default(false);
            $table->timestamps();

            // Claves Foráneas de Catálogos
            $table->foreign('id_categoria')->references('id')->on('cat_categorias');
        });
    }
    public function down() {
        Schema::dropIfExists('detalle_recepciones');
    }
};
