#!/bin/bash
DIR="database/migrations"
mkdir -p $DIR

# Limpiamos migraciones previas generadas por el script para evitar duplicados
rm -f $DIR/*_create_catalogos_table.php
rm -f $DIR/*_create_comprobantes_recepcion_table.php
rm -f $DIR/*_create_detalle_recepciones_table.php
rm -f $DIR/*_create_materiales_inventario_table.php

### 1. Migración de Catálogos
cat << 'EOF' > $DIR/2026_01_01_000001_create_catalogos_table.php
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
EOF

### 2. Migración de Comprobantes de Recepción
cat << 'EOF' > $DIR/2026_01_01_000002_create_comprobantes_recepcion_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('comprobantes_recepcion', function (Blueprint $table) {
            $table->id(); // PK autoincremental
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
EOF

### 3. Migración de Detalle de Recepción (NUEVA TABLA INTERMEDIA)
cat << 'EOF' > $DIR/2026_01_01_000003_create_detalle_recepciones_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('detalle_recepciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion')->onDelete('cascade');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('cantidad_recibida');
            $table->decimal('peso_subtotal', 8, 2)->nullable();
            $table->boolean('requiere_inventario')->default(false);
            $table->timestamps();

            // Claves Foráneas de Catálogos
            $table->foreign('id_categoria')->references('id')->on('cat_categorias');
        });
    }
    public function down() {
        Schema::dropIfExists('detalle_recepciones');
    }
};
EOF

### 4. Migración de Material Inventario
cat << 'EOF' > $DIR/2026_01_01_000004_create_materiales_inventario_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('materiales_inventario', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('comprobante_id')->constrained('comprobantes_recepcion');
            $table->unsignedBigInteger('detalle_id')->nullable(); // Vinculación con el detalle de recepción
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->unsignedBigInteger('id_ubicacion')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->timestamps();

            // Claves Foráneas
            $table->foreign('detalle_id')->references('id')->on('detalle_recepciones')->onDelete('set null');
            $table->foreign('id_categoria')->references('id')->on('cat_categorias');
        });
    }
    public function down() {
        Schema::dropIfExists('materiales_inventario');
    }
};
EOF

echo "Migraciones generadas con éxito en $DIR."
