<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   

public function up(): void
{
    Schema::create('materiales_inventario', function (Blueprint $table) {
        $table->string('id_inventario')->primary(); // Mantiene formato Ej: 1206/A00001
        
        // Ajustamos la FK hacia el comprobante
        $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion')->onDelete('cascade');
        $table->unsignedBigInteger('id_detalle')->nullable();
        $table->unsignedBigInteger('id_categoria');
        $table->unsignedBigInteger('id_estado')->nullable();
        $table->unsignedBigInteger('id_ubicacion')->nullable();
        
        $table->decimal('peso', 8, 2)->nullable();
        $table->timestamps();

        // El resto de las foreign keys (detalle, categoria, estado, ubicacion) quedan igual
        $table->foreign('id_detalle')->references('id_detalle')->on('detalle_recepciones')->onDelete('set null');
        $table->foreign('id_categoria')->references('id')->on('cat_categorias')->onDelete('restrict');
        $table->foreign('id_estado')->references('id')->on('cat_estados')->onDelete('set null');
        $table->foreign('id_ubicacion')->references('id')->on('cat_ubicaciones')->onDelete('set null');
    });
}





   
    public function down() {
        Schema::dropIfExists('materiales_inventario');
    }
};
