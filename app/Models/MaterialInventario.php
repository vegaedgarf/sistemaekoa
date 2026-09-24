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
