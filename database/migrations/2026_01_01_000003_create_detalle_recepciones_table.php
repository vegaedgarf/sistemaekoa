<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('detalle_recepciones', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->string('numero_comprobante');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('cantidad_recibida');
            $table->decimal('peso_subtotal', 8, 2);
            $table->boolean('requiere_inventario')->default(false);
            $table->timestamps();

            // Claves Foráneas
            $table->foreign('numero_comprobante')->references('numero_comprobante')->on('comprobantes_recepcion')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id')->on('cat_categorias');
        });
    }
    public function down() {
        Schema::dropIfExists('detalle_recepciones');
    }
};
