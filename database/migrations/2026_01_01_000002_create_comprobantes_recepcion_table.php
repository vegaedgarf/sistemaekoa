<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('comprobantes_recepcion', function (Blueprint $table) {
            $table->string('numero_comprobante')->primary(); // Ej: 1206
            $table->date('fecha');
            $table->string('donante');
            $table->string('firmas')->nullable();
            $table->decimal('peso_total_estimado', 8, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('comprobantes_recepcion');
    }
};
