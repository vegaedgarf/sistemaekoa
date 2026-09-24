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
