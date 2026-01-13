<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Crea empresas colaboradoras
     */
    public function run(): void
    {
        $empresas = [
            [
                'cif' => 'A12345678',
                'nombre' => 'TechSolutions S.L.',
                'poblacion' => 'San Sebastián',
                'telefono' => '943111222',
                'email' => 'info@techsolutions.com'
            ],
            [
                'cif' => 'B87654321',
                'nombre' => 'Innovasoft Desarrollo',
                'poblacion' => 'Irun',
                'telefono' => '943222333',
                'email' => 'contacto@innovasoft.com'
            ],
            [
                'cif' => 'C11223344',
                'nombre' => 'Digital Euskadi',
                'poblacion' => 'Rentería',
                'telefono' => '943333444',
                'email' => 'rrhh@digitaleuskadi.com'
            ],
            [
                'cif' => 'D55667788',
                'nombre' => 'CodeFactory Labs',
                'poblacion' => 'Hernani',
                'telefono' => '943444555',
                'email' => 'practicas@codefactory.com'
            ],
            [
                'cif' => 'E99887766',
                'nombre' => 'WebMakers Gipuzkoa',
                'poblacion' => 'Eibar',
                'telefono' => '943555666',
                'email' => 'info@webmakers.eus'
            ]
        ];

        foreach ($empresas as $empresa) {
            Empresa::create($empresa);
        }

        echo "✅ Creadas " . Empresa::count() . " empresas\n";
    }
}