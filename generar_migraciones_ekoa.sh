#!/bin/bash
DIR="database/migrations"
mkdir -p $DIR

# Limpiamos migraciones previas para evitar duplicados
rm -f $DIR/*_create_catalogos_table.php
rm -f $DIR/*_create_comprobantes_recepcion_table.php
rm -f $DIR/*_create_detalle_recepciones_table.php
rm -f $DIR/*_create_materiales_inventario_table.php

# 1. Migración de Catálogos (Agregamos identificador_letra)
cat << 'EOF' > $DIR/2026_01_01_000001_create_catalogos_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tablas = ['cat_categorias', 'cat_marcas', 'cat_estados', 'cat_ubicaciones', 'cat_tareas', 'cat_sistemas_operativos'];
        foreach ($tablas as $tabla) {
            Schema::create($tabla, function (Blueprint $table) use ($tabla) {
                $table->id();
                $table->string('nombre');
                if ($tabla === 'cat_categorias') {
                    $table->char('identificador_letra', 1)->unique()->nullable();
                }
                $table->timestamps();
            });
        }
    }
    public function down(): void {
        $tablas = ['cat_sistemas_operativos', 'cat_tareas', 'cat_ubicaciones', 'cat_estados', 'cat_marcas', 'cat_categorias'];
        foreach ($tablas as $tabla) {
            Schema::dropIfExists($tabla);
        }
    }
};
EOF

# 2. Migración de Comprobante de Recepción (nro_comprobante y cedente)
cat << 'EOF' > $DIR/2026_01_01_000002_create_comprobantes_recepcion_table.php
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
EOF

# 3. Migración de Detalle de Recepciones (Intermedia)
cat << 'EOF' > $DIR/2026_01_01_000003_create_detalle_recepciones_table.php
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
EOF

# 4. Migración de Materiales de Inventario (Equipos)
cat << 'EOF' > $DIR/2026_01_01_000004_create_materiales_inventario_table.php
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
EOF

echo "Migraciones creadas exitosamente en $DIR."
