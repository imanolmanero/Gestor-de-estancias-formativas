<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResultadoAprendizaje;
use App\Models\Competencia;
use App\Models\Asignatura;
use DB;
class ResultadoAprendizajeController extends Controller
{
    
    public function store(Request $request)
    
    {
        $request->validate([
            'descripcion' => 'required|string',
            'id_asignatura' => 'required|integer',
            'id_grado' => 'required|integer',
        ]);
        DB::transaction(function () use ($request){
            $ra = ResultadoAprendizaje::create([
                'descripcion' => $request->descripcion,
                'id_grado' => $request->id_grado,
                'id_asignatura' => $request->id_asignatura,
            ]);
        });
        return response()->json(['message' => 'Resultado de Aprendizaje guardado correctamente.'], 201);


    }
    public function obtenerResultadosPorGrado($id_grado)
    {
        try{
            $id_asignaturas = Asignatura::where('id_grado', $id_grado)->pluck('id_asignatura');
            $resultados = ResultadoAprendizaje::whereIn('id_asignatura', $id_asignaturas)
            ->with('asignatura')
            ->get();
            return response()->json($resultados, 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error al obtener los resultados de aprendizaje', 'error' => $e->getMessage()], 500);
        }
    }

   
}
