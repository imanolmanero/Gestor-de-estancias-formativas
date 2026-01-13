<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;
use App\Models\Asignatura;
use App\Models\ResultadoAprendizaje;
use App\Models\CompetenciaTecnica;

class GradoSeeder extends Seeder
{
    /**
     * Crea grados con sus asignaturas, RAs y competencias técnicas
     */
    public function run(): void
    {
        // ==========================================
        // GRADO 1: DAM - Desarrollo Aplicaciones Multiplataforma
        // ==========================================
        $dam = Grado::create([
            'nombre' => 'Desarrollo de Aplicaciones Multiplataforma',
            'familia' => 'Informática y Comunicaciones',
            'codigo' => 'IFC303'
        ]);

        // Asignaturas DAM
        $programacion = Asignatura::create([
            'id_grado' => $dam->id_grado,
            'nombre' => 'Programación'
        ]);

        $bbdd = Asignatura::create([
            'id_grado' => $dam->id_grado,
            'nombre' => 'Bases de Datos'
        ]);

        $entornos = Asignatura::create([
            'id_grado' => $dam->id_grado,
            'nombre' => 'Entornos de Desarrollo'
        ]);

        // Resultados de Aprendizaje - Programación
        ResultadoAprendizaje::create([
            'id_asignatura' => $programacion->id_asignatura,
            'descripcion' => 'Reconoce la estructura de un programa informático, identificando y relacionando los elementos propios del lenguaje de programación utilizado'
        ]);

        ResultadoAprendizaje::create([
            'id_asignatura' => $programacion->id_asignatura,
            'descripcion' => 'Escribe y prueba programas sencillos, reconociendo y aplicando los fundamentos de la programación orientada a objetos'
        ]);

        ResultadoAprendizaje::create([
            'id_asignatura' => $programacion->id_asignatura,
            'descripcion' => 'Escribe y depura código, analizando y utilizando las estructuras de control del lenguaje'
        ]);

        // Resultados de Aprendizaje - BBDD
        ResultadoAprendizaje::create([
            'id_asignatura' => $bbdd->id_asignatura,
            'descripcion' => 'Reconoce los elementos de las bases de datos analizando sus funciones y valorando la utilidad de sistemas gestores'
        ]);

        ResultadoAprendizaje::create([
            'id_asignatura' => $bbdd->id_asignatura,
            'descripcion' => 'Crea bases de datos definiendo su estructura y las características de sus elementos según el modelo relacional'
        ]);

        // Resultados de Aprendizaje - Entornos
        ResultadoAprendizaje::create([
            'id_asignatura' => $entornos->id_asignatura,
            'descripcion' => 'Reconoce los elementos y herramientas que intervienen en el desarrollo de un programa informático, analizando sus características'
        ]);

        // Competencias Técnicas DAM
        $compProgramacion = CompetenciaTecnica::create([
            'id_grado' => $dam->id_grado,
            'descripcion' => 'Programación y desarrollo de software'
        ]);

        $compBBDD = CompetenciaTecnica::create([
            'id_grado' => $dam->id_grado,
            'descripcion' => 'Diseño y gestión de bases de datos'
        ]);

        $compHerramientas = CompetenciaTecnica::create([
            'id_grado' => $dam->id_grado,
            'descripcion' => 'Uso de herramientas de desarrollo'
        ]);

        // Vincular competencias con RAs (tabla pivot)
        // La competencia de programación afecta a los 3 RAs de programación
        $rasProgr = ResultadoAprendizaje::where('id_asignatura', $programacion->id_asignatura)->get();
        foreach ($rasProgr as $ra) {
            $compProgramacion->resultadosAprendizaje()->attach($ra->id_resultado);
        }

        // La competencia de BBDD afecta a los 2 RAs de BBDD
        $rasBBDD = ResultadoAprendizaje::where('id_asignatura', $bbdd->id_asignatura)->get();
        foreach ($rasBBDD as $ra) {
            $compBBDD->resultadosAprendizaje()->attach($ra->id_resultado);
        }

        // La competencia de herramientas afecta al RA de entornos
        $rasEntornos = ResultadoAprendizaje::where('id_asignatura', $entornos->id_asignatura)->get();
        foreach ($rasEntornos as $ra) {
            $compHerramientas->resultadosAprendizaje()->attach($ra->id_resultado);
        }

        // ==========================================
        // GRADO 2: DAW - Desarrollo Aplicaciones Web
        // ==========================================
        $daw = Grado::create([
            'nombre' => 'Desarrollo de Aplicaciones Web',
            'familia' => 'Informática y Comunicaciones',
            'codigo' => 'IFC304'
        ]);

        // Asignaturas DAW
        $dwes = Asignatura::create([
            'id_grado' => $daw->id_grado,
            'nombre' => 'Desarrollo Web Entorno Servidor'
        ]);

        $dwec = Asignatura::create([
            'id_grado' => $daw->id_grado,
            'nombre' => 'Desarrollo Web Entorno Cliente'
        ]);

        // RAs DAW
        ResultadoAprendizaje::create([
            'id_asignatura' => $dwes->id_asignatura,
            'descripcion' => 'Selecciona las arquitecturas y tecnologías de programación sobre clientes Web'
        ]);

        ResultadoAprendizaje::create([
            'id_asignatura' => $dwec->id_asignatura,
            'descripcion' => 'Desarrolla aplicaciones Web interactivas integrando mecanismos de manejo de eventos'
        ]);

        // Competencias DAW
        $compWeb = CompetenciaTecnica::create([
            'id_grado' => $daw->id_grado,
            'descripcion' => 'Desarrollo de aplicaciones web full-stack'
        ]);

        // Vincular
        $rasDwes = ResultadoAprendizaje::where('id_asignatura', $dwes->id_asignatura)->get();
        $rasDwec = ResultadoAprendizaje::where('id_asignatura', $dwec->id_asignatura)->get();
        foreach ($rasDwes->merge($rasDwec) as $ra) {
            $compWeb->resultadosAprendizaje()->attach($ra->id_resultado);
        }

        echo "✅ Creados " . Grado::count() . " grados\n";
        echo "✅ Creadas " . Asignatura::count() . " asignaturas\n";
        echo "✅ Creados " . ResultadoAprendizaje::count() . " resultados de aprendizaje\n";
        echo "✅ Creadas " . CompetenciaTecnica::count() . " competencias técnicas\n";
    }
}