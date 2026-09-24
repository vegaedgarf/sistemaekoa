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
            'cedente'             => 'Registro Inicial / Apertura', // Campo obligatorio según tu migración
            'peso_total_estimado' => 0,
            'firmas'              => 'N/A',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        $this->command->info('Comprobante de recepción inicial con número 3560 creado exitosamente.');
    }
}