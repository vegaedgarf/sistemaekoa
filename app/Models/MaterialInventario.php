<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaterialInventario extends Model {
    protected $table = 'materiales_inventario';
    protected $guarded = [];

    public function comprobante() {
        return $this->belongsTo(ComprobanteRecepcion::class, 'comprobante_id', 'id');
    }

    public function detalleRecepcion() {
        return $this->belongsTo(DetalleRecepcion::class, 'detalle_id', 'id');
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
