<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
       // Poblar tabla de Categorías con su identificador_letra identificatoria
           $categorias = [
               ['nombre' => 'CPU', 'identificador_letra' => 'C'],
               ['nombre' => 'Notebook', 'identificador_letra' => 'N'],
               ['nombre' => 'Monitor', 'identificador_letra' => 'M'],
               ['nombre' => 'Memoria', 'identificador_letra' => 'R'], // R de RAM
               ['nombre' => 'Motherboard', 'identificador_letra' => 'P'], // P de Placa Madre
               ['nombre' => 'Periféricos Varios', 'identificador_letra' => 'V']
           ];
           DB::table('cat_categorias')->insert($categorias);
       /* DB::table('cat_estados')->insert([
            ['nombre' => 'Funciona'],
            ['nombre' => 'No funciona'],
            ['nombre' => 'En proceso'],
            ['nombre' => 'Sin probar'],
        ]);

        DB::table('cat_ubicaciones')->insert([
            ['nombre' => 'Entrada'],
            ['nombre' => 'Reparación'],
            ['nombre' => 'Instalación'],
            ['nombre' => 'Prueba Final'],
            ['nombre' => 'Donado'],
            ['nombre' => 'Material Didáctico'],
            ['nombre' => 'Disposición Final'],
        ]);*/
    }
}