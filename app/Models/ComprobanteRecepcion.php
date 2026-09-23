<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRecepcion extends Model {
    protected $table = 'comprobantes_recepcion';
   // protected $primaryKey = 'numero_comprobante';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];


   
    protected $fillable = [
        'numero_comprobante',
        'fecha',
        'cedente',
        'peso_total_estimado',
        'firmas'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleRecepcion::class, 'comprobante_id', 'id');
    }



    public function materialesInventario() {
        return $this->hasMany(MaterialInventario::class, 'numero_comprobante', 'numero_comprobante');
    }
}
