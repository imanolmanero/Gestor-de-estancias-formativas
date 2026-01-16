<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Grado;

class GradosController extends Controller
{
public function getGrados()
{
    try {
        return response()->json(Grado::all());
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}