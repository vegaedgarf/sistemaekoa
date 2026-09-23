<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    

public function up(): void
{
    Schema::create('detalle_recepciones', function (Blueprint $table) {
        $table->id('id_detalle');
        
        // Reemplazamos numero_comprobante por la convención de Laravel
        $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion')->onDelete('cascade');
        $table->unsignedBigInteger('id_categoria');
        
        $table->integer('cantidad_recibida');
        $table->decimal('peso_subtotal', 8, 2)->nullable();
        $table->boolean('requiere_inventario')->default(true);
        $table->timestamps();

        $table->foreign('id_categoria')->references('id')->on('cat_categorias')->onDelete('restrict');
    });
}


    public function down() {
        Schema::dropIfExists('detalle_recepciones');
    }
};
