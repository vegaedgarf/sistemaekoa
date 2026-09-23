<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetalleRecepcion extends Model {
    protected $table = 'detalle_recepciones';
    protected $guarded = [];

    protected $casts = [
        'requiere_inventario' => 'boolean',
    ];

    public function comprobante() {
        return $this->belongsTo(ComprobanteRecepcion::class, 'comprobante_id', 'id');
    }

    public function categoria() {
        return $this->belongsTo(CatCategoria::class, 'id_categoria');
    }

    public function inventarios() {
        return $this->hasMany(MaterialInventario::class, 'detalle_id', 'id');
    }
}
