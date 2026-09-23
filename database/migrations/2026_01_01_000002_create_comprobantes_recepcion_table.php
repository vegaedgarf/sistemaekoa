<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  

  public function up(): void
{
    Schema::create('comprobantes_recepcion', function (Blueprint $table) {
        $table->id(); // Clave primaria estándar de Laravel (BIGINT UNSIGNED)
        $table->string('numero_comprobante')->unique()->nullable(); // Tu segunda clave para uso del negocio
        $table->date('fecha');
        $table->string('cedente');
        $table->decimal('peso_total_estimado', 8, 2)->nullable();
        $table->text('firmas')->nullable();
        $table->timestamps();
    });
}
    public function down() {
        Schema::dropIfExists('comprobantes_recepcion');
    }
};
