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
                return response()->json(['message' => 'Competencia técnica guardada con éxito', 'competencia' => $competencia], 201);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al guardar la competencia técnica: ' . $e->getMessage()], 500);
            }
        }
    }

?>