<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Services\Notas\CalculoNotaFinalService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AlumnoController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('datosRECIBIDOS:', $request->all());
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'nombre' => 'required|string|max:100',
                'apellidos' => 'required|string|max:150',
                'telefono' => 'nullable|string|max:20',
                'id_grado' => 'required|integer|exists:grado,id_grado', 
            ]);

                
                $user = User::create([
                    'email' => $validatedData['email'],
                    'password_hash' => Hash::make($validatedData['password']),
                    'nombre' => $validatedData['nombre'],
                    'apellidos' => $validatedData['apellidos'],
                    'telefono' => $validatedData['telefono'] ?? null,
                    'tipo_usuario' => 'alumno', // forzamos que sea alumno
                ]);

                $alumno = Alumno::create([
                    'id_alumno' => $user->id_usuario, 
                    'id_grado'  => $validatedData['id_grado'],
                ]);

                return ['user' => $user, 'alumno' => $alumno];

            return response()->json([
                'message' => 'Alumno creado con éxito'
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function notaFinal(Request $request, $idAlumno, $idAsignatura)
    {
        $user = $request->user();

        // Solo tutores
        if (!$user->esTutorCentro()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Validaciones básicas
        if (!Alumno::where('id_alumno', $idAlumno)->exists()) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        if (!Asignatura::find($idAsignatura)) {
            return response()->json(['message' => 'Asignatura no encontrada'], 404);
        }

        try {
            $notaFinal = app(CalculoNotaFinalService::class)
                ->calcular($idAlumno, $idAsignatura);

            return response()->json([
                'id_alumno'     => $idAlumno,
                'id_asignatura' => $idAsignatura,
                'nota_final'    => $notaFinal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getNotas(Request $request, $idAlumno)
    {
        $user = $request->user();

        // Validar alumno
        $alumno = Alumno::where('id_alumno', $idAlumno)->first();

        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }
      

        try {
            $asignaturas = Asignatura::where('id_grado', $alumno->id_grado)
                ->leftJoin('nota_asignatura_centro', function ($join) use ($idAlumno) {
                    $join->on(
                        'asignatura.id_asignatura',
                        '=',
                        'nota_asignatura_centro.id_asignatura'
                    )
                    ->on('nota_asignatura_centro.id_alumno','=',DB::raw($idAlumno));
                })
                ->select(
                    'asignatura.id_asignatura',
                    'asignatura.nombre',
                    'nota_asignatura_centro.nota'
                )
                ->get();

            return response()->json([
                'alumno_id' => $idAlumno,
                'asignaturas' => $asignaturas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las notas',
                'error' => $e->getMessage()
            ], 500);
        }
    
    }
    public function getEstanciaAlumno($idAlumno)
{
    try {
        $estancia = DB::table('estancia')
            ->where('id_alumno', $idAlumno)
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if (!$estancia) {
            return response()->json([
                'message' => 'No se encontró ninguna estancia para este alumno'
            ], 404);
        }

        return response()->json($estancia);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al obtener la estancia',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function ponerNotasTrans(Request $request, $idAlumno)
{
    $user = $request->user();

    if (!$user->esTutorEmpresa()) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    $validatedData = $request->validate([
        'id_estancia' => 'required|integer|exists:estancia,id_estancia',
        'notas' => 'required|array',
        'notas.*.id_competencia_trans' => 'required|integer|exists:competencia_transversal,id_competencia_trans',
        'notas.*.nota' => 'required|numeric|min:1|max:4',
    ]);

    // Verificar que la estancia pertenece al alumno
    $estancia = DB::table('estancia')
        ->where('id_estancia', $validatedData['id_estancia'])
        ->where('id_alumno', $idAlumno)
        ->first();

    if (!$estancia) {
        return response()->json([
            'message' => 'La estancia no pertenece a este alumno'
        ], 404);
    }

    // Verificar si ya existen notas para esta estancia
    $notasExistentes = DB::table('nota_competencia_transversal')
        ->where('id_estancia', $validatedData['id_estancia'])
        ->exists();

    if ($notasExistentes) {
        return response()->json([
            'message' => 'Las notas para esta estancia ya han sido registradas y no pueden modificarse'
        ], 422);
    }

    try {
        foreach ($validatedData['notas'] as $notaData) {
            DB::table('nota_competencia_transversal')->insert([
                'id_estancia' => $validatedData['id_estancia'],
                'id_competencia_trans' => $notaData['id_competencia_trans'],
                'nota' => $notaData['nota'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json(['message' => 'Notas guardadas con éxito']);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al guardar las notas',
            'error' => $e->getMessage()
        ], 500);
    }
}
}