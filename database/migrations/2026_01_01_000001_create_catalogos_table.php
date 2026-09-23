<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->char('letra', 1)->unique(); // Letra para prefijo de ID
            $table->timestamps();
        });
        Schema::create('cat_marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('cat_modelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_marca')->constrained('cat_marcas')->onDelete('cascade');
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('cat_estados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('cat_ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('cat_tareas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('cat_sistemas_operativos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // El orden de eliminación (drop) debe ser inverso a la creación por las claves foráneas
        Schema::dropIfExists('cat_sistemas_operativos');
        Schema::dropIfExists('cat_tareas');
        Schema::dropIfExists('cat_ubicaciones');
        Schema::dropIfExists('cat_estados');
        Schema::dropIfExists('cat_modelos');
        Schema::dropIfExists('cat_marcas');
        Schema::dropIfExists('cat_categorias');
    }
};