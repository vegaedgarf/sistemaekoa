<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detalle_recepciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion')->onDelete('cascade');
            $table->foreignId('id_categoria')->constrained('cat_categorias');
            $table->integer('cantidad_recibida');
            $table->decimal('peso_subtotal', 8, 2)->nullable();
            $table->boolean('requiere_inventario')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('detalle_recepciones');
    }
};
