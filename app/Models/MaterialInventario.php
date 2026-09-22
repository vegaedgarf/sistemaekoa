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
