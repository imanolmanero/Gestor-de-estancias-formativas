<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompetenciaTecnica;

class CompetenciaTecnicaController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate([
            'descripcion' => 'required|string',
            'id_grado' => 'required|integer|exists:grado,id_grado',
        ]);
        
        try {
            $competencia = CompetenciaTecnica::create($datos);
            return response()->json([
                'message' => 'Competencia técnica guardada con éxito',
                'competencia' => $competencia
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar la competencia técnica: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las competencias técnicas de un grado
     */
    public function obtenerPorGrado($idGrado)
    {
        try {
            $competencias = CompetenciaTecnica::where('id_grado', $idGrado)
                ->select('id_competencia', 'descripcion')
                ->get();

            \Log::info('Competencias encontradas para grado ' . $idGrado, [
                'count' => $competencias->count(),
                'competencias' => $competencias
            ]);

            return response()->json($competencias);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener competencias técnicas: ' . $e->getMessage()
            ], 500);
        }
    }
}