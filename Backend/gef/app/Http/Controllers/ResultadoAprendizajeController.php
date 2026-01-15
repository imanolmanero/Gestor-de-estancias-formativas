<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResultadoAprendizaje;
use App\Models\Competencia;
use DB;
class ResultadoAprendizajeController extends Controller
{
    
    public function store(Request $request)
    
    {
        $request->validate([
            'descripcion' => 'required|string',
            'grado_id' => 'required|integer',
            'competencias' => 'required|array',
            'competencias.*.descripcion' => 'required|string',
        ]);
        DB::transaction(function () use ($request){
            $ra = ResultadoAprendizaje::create([
                'descripcion' => $request->descripcion,
                'grado_id' => $request->grado_id,
            ]);
            foreach ($request->competencias as $compData) {
                Competencia::create([
                    'descripcion' => $compData['descripcion'],
                    'resultado_aprendizaje_id' => $ra->id,
                ]);
            }
        });
        return response()->json(['message' => 'Resultado de Aprendizaje guardado correctamente.'], 201);


    }

   
}
