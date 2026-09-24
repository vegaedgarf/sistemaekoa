<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRecepcion extends Model {
    protected $table = 'comprobantes_recepcion';
    protected $fillable = ['nro_comprobante', 'fecha', 'cedente', 'firmas', 'peso_total_estimado'];
    
    public function detalles() {
        return $this->hasMany(DetalleRecepcion::class, 'comprobante_id');
    }
}
