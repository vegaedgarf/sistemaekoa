<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRecepcion extends Model {
    protected $table = 'comprobantes_recepcion';
    // Laravel asume 'id' autoincremental por defecto
    protected $guarded = [];

    public function detalles() {
        return $this->hasMany(DetalleRecepcion::class, 'comprobante_id', 'id');
    }

    public function materialesInventario() {
        return $this->hasMany(MaterialInventario::class, 'comprobante_id', 'id');
    }
}
