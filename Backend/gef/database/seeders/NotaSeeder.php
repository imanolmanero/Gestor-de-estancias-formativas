<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\NotaAsignaturaCentro;
use App\Models\Estancia;
use App\Models\CompetenciaTecnica;
use App\Models\CompetenciaTransversal;
use App\Models\NotaCompetenciaTransversal;

class NotaSeeder extends Seeder
{
    /**
     * Crea notas de centro y de empresa
     */
    public function run(): void
    {
        // ==========================================
        // 1. NOTAS DEL CENTRO (80%)
        // ==========================================
        $alumnos = Alumno::all();
        
        foreach ($alumnos as $alumno) {
            $asignaturas = Asignatura::where('id_grado', $alumno->id_grado)->get();
            
            foreach ($asignaturas as $asignatura) {
                // Generar nota aleatoria realista (5-10)
                $nota = rand(50, 100) / 10;
                
                NotaAsignaturaCentro::create([
                    'id_alumno' => $alumno->id_alumno,
                    'id_asignatura' => $asignatura->id_asignatura,
                    'nota' => $nota
                ]);
            }
        }

        echo "✅ Creadas " . NotaAsignaturaCentro::count() . " notas del centro\n";

        // ==========================================
        // 2. NOTAS DE EMPRESA - COMPETENCIAS TÉCNICAS
        // ==========================================
        // Solo para estancias ACTIVAS y FINALIZADAS
        $estancias = Estancia::whereDate('fecha_inicio', '<=', now())->get();

        foreach ($estancias as $estancia) {
            $alumno = $estancia->alumno;
            $competencias = CompetenciaTecnica::where('id_grado', $alumno->id_grado)->get();

            foreach ($competencias as $competencia) {
                // Generar nota en escala 0-4
                $nota = rand(2, 4); // 2=Deficiente, 3=Satisfactorio, 4=Muy satisfactorio

                // USAR EL MÉTODO propagarNotaARAs() para aplicar el flujo de notas
                $competencia->propagarNotaARAs($estancia->id_estancia, $nota);
            }
        }

        $totalNotasRA = \App\Models\NotaResultadoAprendizaje::count();
        echo "✅ Propagadas notas a {$totalNotasRA} resultados de aprendizaje\n";

        // ==========================================
        // 3. NOTAS DE EMPRESA - COMPETENCIAS TRANSVERSALES
        // ==========================================
        $competenciasTransversales = CompetenciaTransversal::all();

        foreach ($estancias as $estancia) {
            foreach ($competenciasTransversales as $competencia) {
                // Nota en escala 0-4
                $nota = rand(2, 4);

                NotaCompetenciaTransversal::create([
                    'id_estancia' => $estancia->id_estancia,
                    'id_competencia_trans' => $competencia->id_competencia_trans,
                    'nota' => $nota
                ]);
            }
        }

        echo "✅ Creadas " . NotaCompetenciaTransversal::count() . " notas de competencias transversales\n";

        // ==========================================
        // RESUMEN
        // ==========================================
        echo "\n📊 RESUMEN DE NOTAS:\n";
        foreach ($estancias->take(2) as $estancia) {
            echo "\n   Alumno: {$estancia->alumno->usuario->nombre_completo}\n";
            echo "   Empresa: {$estancia->empresa->nombre}\n";
            echo "   Estado: {$estancia->estado}\n";
            
            // Mostrar notas técnicas por asignatura
            $asignaturas = $estancia->asignaturasEvaluadas();
            foreach ($asignaturas as $asignatura) {
                $notaTecnica = $asignatura->calcularNotaTecnicaEmpresa($estancia->id_estancia);
                echo "   → {$asignatura->nombre}: " . number_format($notaTecnica, 2) . "/4\n";
            }
            
            // Mostrar nota media transversales
            $mediaTransversales = $estancia->notaMediaTransversales();
            echo "   → Competencias Transversales (media): " . number_format($mediaTransversales, 2) . "/4\n";
        }
    }
}