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
