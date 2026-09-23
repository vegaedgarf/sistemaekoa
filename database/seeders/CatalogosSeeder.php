<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
       // Poblar tabla de Categorías con su letra identificatoria
           $categorias = [
               ['nombre' => 'CPU', 'letra' => 'C'],
               ['nombre' => 'Notebook', 'letra' => 'N'],
               ['nombre' => 'Monitor', 'letra' => 'M'],
               ['nombre' => 'Memoria', 'letra' => 'R'], // R de RAM
               ['nombre' => 'Motherboard', 'letra' => 'P'], // P de Placa Madre
               ['nombre' => 'Periféricos Varios', 'letra' => 'V']
           ];
           DB::table('cat_categorias')->insert($categorias);
        DB::table('cat_estados')->insert([
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
        ]);
    }
}