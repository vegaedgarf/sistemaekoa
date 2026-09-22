#!/bin/bash
DIR="app/Models"
mkdir -p $DIR

### 1. Catálogos Básicos
for cat in Categoria Marca Estado Ubicacion Tarea SistemaOperativo; do
table_name="cat_$(echo $cat | tr '[:upper:]' '[:lower:]' | sed 's/sistemaoperativo/sistemas_operativos/g' | sed 's/marca/marcas/g' | sed 's/estado/estados/g' | sed 's/ubicacion/ubicaciones/g' | sed 's/tarea/tareas/g' | sed 's/categoria/categorias/g')"
cat << EOF > $DIR/Cat${cat}.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cat${cat} extends Model {
    protected \$table = '${table_name}';
    protected \$guarded = [];
}
EOF
done

### 2. Comprobante de Recepción
cat << 'EOF' > $DIR/ComprobanteRecepcion.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRecepcion extends Model {
    protected $table = 'comprobantes_recepcion';
    protected $primaryKey = 'numero_comprobante';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function detalles() {
        return $this->hasMany(DetalleRecepcion::class, 'numero_comprobante', 'numero_comprobante');
    }

    public function materialesInventario() {
        return $this->hasMany(MaterialInventario::class, 'numero_comprobante', 'numero_comprobante');
    }
}
EOF

### 3. Detalle de Recepción (NUEVA TABLA INTERMEDIA)
cat << 'EOF' > $DIR/DetalleRecepcion.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetalleRecepcion extends Model {
    protected $table = 'detalle_recepciones';
    protected $primaryKey = 'id_detalle';
    protected $guarded = [];

    protected $casts = [
        'requiere_inventario' => 'boolean',
    ];

    public function comprobante() {
        return $this->belongsTo(ComprobanteRecepcion::class, 'numero_comprobante', 'numero_comprobante');
    }

    public function categoria() {
        return $this->belongsTo(CatCategoria::class, 'id_categoria');
    }

    public function inventarios() {
        return $this->hasMany(MaterialInventario::class, 'id_detalle', 'id_detalle');
    }
}
EOF

### 4. Material Inventario
cat << 'EOF' > $DIR/MaterialInventario.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaterialInventario extends Model {
    protected $table = 'materiales_inventario';
    protected $primaryKey = 'id_inventario';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function comprobante() {
        return $this->belongsTo(ComprobanteRecepcion::class, 'numero_comprobante', 'numero_comprobante');
    }

    public function detalleRecepcion() {
        return $this->belongsTo(DetalleRecepcion::class, 'id_detalle', 'id_detalle');
    }

    public function categoria() {
        return $this->belongsTo(CatCategoria::class, 'id_categoria');
    }

    public function estado() {
        return $this->belongsTo(CatEstado::class, 'id_estado');
    }

    public function ubicacion() {
        return $this->belongsTo(CatUbicacion::class, 'id_ubicacion');
    }
}
EOF

echo "Modelos generados con éxito en $DIR, incluyendo la nueva entidad DetalleRecepcion."
