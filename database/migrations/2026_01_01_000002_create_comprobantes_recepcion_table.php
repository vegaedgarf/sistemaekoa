<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comprobantes_recepcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nro_comprobante')->unique();
            $table->date('fecha');
            $table->string('cedente'); 
            $table->string('firmas')->nullable();
            $table->decimal('peso_total_estimado', 8, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('comprobantes_recepcion');
    }
};
