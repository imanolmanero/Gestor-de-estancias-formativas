<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompetenciaTransversal;

class CompetenciaTransversalSeeder extends Seeder
{
    /**
     * Crea las 4 competencias transversales fijas del sistema
     */
    public function run(): void
    {
        $competencias = [
            'Trabajo en equipo y colaboración',
            'Responsabilidad, autonomía y capacidad de organización',
            'Comunicación efectiva y habilidades interpersonales',
            'Resolución de problemas y pensamiento crítico'
        ];

        foreach ($competencias as $competencia) {
            CompetenciaTransversal::create([
                'descripcion' => $competencia
            ]);
        }

        echo "✅ Creadas " . CompetenciaTransversal::count() . " competencias transversales\n";
    }
}