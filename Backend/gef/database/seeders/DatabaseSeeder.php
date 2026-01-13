<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders en el orden correcto
     * 
     * ORDEN DE EJECUCIÓN (respeta dependencias):
     * 1. Usuarios (base)
     * 2. Grados + Asignaturas + RAs + Competencias Técnicas
     * 3. Competencias Transversales
     * 4. Alumnos (vincula usuarios con grados)
     * 5. Empresas
     * 6. Estancias (vincula todo)
     * 7. Notas (requiere estancias activas)
     */
    public function run(): void
    {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════╗\n";
        echo "║   🚀 INICIANDO SEEDERS - SISTEMA FCT                  ║\n";
        echo "╚════════════════════════════════════════════════════════╝\n";
        echo "\n";

        $inicio = microtime(true);

        // 1. Usuarios
        echo "📌 [1/7] Creando usuarios...\n";
        $this->call(UsuarioSeeder::class);
        echo "\n";

        // 2. Grados (incluye asignaturas, RAs y competencias técnicas)
        echo "📌 [2/7] Creando estructura académica...\n";
        $this->call(GradoSeeder::class);
        echo "\n";

        // 3. Competencias Transversales
        echo "📌 [3/7] Creando competencias transversales...\n";
        $this->call(CompetenciaTransversalSeeder::class);
        echo "\n";

        // 4. Alumnos
        echo "📌 [4/7] Vinculando alumnos con grados...\n";
        $this->call(AlumnoSeeder::class);
        echo "\n";

        // 5. Empresas
        echo "📌 [5/7] Creando empresas...\n";
        $this->call(EmpresaSeeder::class);
        echo "\n";

        // 6. Estancias (incluye horarios)
        echo "📌 [6/7] Creando estancias y horarios...\n";
        $this->call(EstanciaSeeder::class);
        echo "\n";

        // 7. Notas
        echo "📌 [7/7] Generando notas...\n";
        $this->call(NotaSeeder::class);
        echo "\n";

        $tiempo = round(microtime(true) - $inicio, 2);

        echo "\n";
        echo "╔════════════════════════════════════════════════════════╗\n";
        echo "║   ✅ SEEDERS COMPLETADOS EN {$tiempo}s                     ║\n";
        echo "╚════════════════════════════════════════════════════════╝\n";
        echo "\n";
        echo "🎯 Tu base de datos está lista para pruebas!\n";
        echo "   → Usuarios: con contraseña 'password123'\n";
        echo "   → Estancias: activas, finalizadas y próximas\n";
        echo "   → Notas: centro + empresa con flujo completo\n";
        echo "\n";
        echo "💡 Próximo paso: php artisan tinker\n";
        echo "\n";
    }
}