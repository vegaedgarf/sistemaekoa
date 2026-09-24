#!/bin/bash
DIR="app/Models"
mkdir -p $DIR

# 1. Catálogos Básicos
for cat in Categoria Marca Estado Ubicacion Tarea SistemaOperativo; do
    table_name="cat_$(echo $cat | tr '[:upper:]' '[:lower:]' | sed 's/sistemaoperativo/sistemas_operativos/g' | sed 's/marca/marcas/g' | sed 's/estado/estados/g' | sed 's/ubicacion/ubicaciones/g' | sed 's/tarea/tareas/g' | sed 's/categoria/categorias/g')"
    cat << EOF > $DIR/Cat${cat}.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cat${cat} extends Model {
    protected \$table = '${table_name}';
    protected \$guarded = ['id'];
}
EOF
done

# 2. Entidades de Negocio
cat << 'EOF' > $DIR/ComprobanteRecepcion.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRecepcion extends Model {
    protected $table = 'comprobantes_recepcion';
    protected $fillable = ['nro_comprobante', 'fecha', 'nombre', 'apellido', 'dni', 'cuit', 'mail_principal', 'mail_secundario', 'firmas', 'peso_total_estimado'];
    
    public function detalles() {
        return $this->hasMany(DetalleRecepcion::class, 'comprobante_id');
    }
}
EOF

cat << 'EOF' > $DIR/DetalleRecepcion.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetalleRecepcion extends Model {
    protected $table = 'detalle_recepciones';
    protected $fillable = ['comprobante_id', 'id_categoria', 'cantidad_recibida', 'peso_subtotal', 'requiere_inventario'];
    
    public function comprobante() {
        return $this->belongsTo(ComprobanteRecepcion::class, 'comprobante_id');
    }
    
    public function categoria() {
        return $this->belongsTo(CatCategoria::class, 'id_categoria');
    }
}
EOF

cat << 'EOF' > $DIR/MaterialInventario.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaterialInventario extends Model {
    protected $table = 'materiales_inventario';
    protected $fillable = ['comprobante_id', 'detalle_id', 'id_categoria', 'peso', 'id_estado', 'id_ubicacion'];
    
    public function categoria() {
        return $this->belongsTo(CatCategoria::class, 'id_categoria');
    }
}
EOF

echo "Modelos creados exitosamente en $DIR."

