<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materiales_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion');
            $table->foreignId('detalle_id')->nullable()->constrained('detalle_recepciones')->onDelete('set null');
            $table->foreignId('id_categoria')->constrained('cat_categorias');
            $table->decimal('peso', 8, 2)->nullable();
            $table->foreignId('id_estado')->nullable()->constrained('cat_estados');
            $table->foreignId('id_ubicacion')->nullable()->constrained('cat_ubicaciones');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('materiales_inventario');
    }
};
