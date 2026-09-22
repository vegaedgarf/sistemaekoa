<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('cat_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
        
        // (Aquí se pueden agregar el resto de los catálogos: marcas, estados, ubicaciones, etc.)
    }
    public function down() {
        Schema::dropIfExists('cat_categorias');
    }
};
