<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InicioComprobantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertamos el registro base para que el próximo comprobante sea 3561
        DB::table('comprobantes_recepcion')->insert([
            'nro_comprobante'     => 3560,
            'fecha'               => Carbon::now(),
            'nombre'              => 'Registro Inicial', 
            'apellido'            => 'Apertura',
            'dni'                 => '00000000',
            'cuit'                => '00-00000000-0',
            'mail_principal'      => 'sistema@local.com',
            'mail_secundario'     => null,
            'firmas'              => 'N/A',
            'peso_total_estimado' => 0,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        $this->command->info('Comprobante de recepción inicial con número 3560 creado exitosamente.');
    }
}