<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;

class InicioController extends Controller
{
    public function index()
    {
        //Obtener las 3 recetas mas botada
        $votadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->take(3)->get();

        //Obtener las recetas mas nuevas
        $nuevas_recetas = Receta::latest()->take(5)->get();

        //Obtener todas las categorias
        $categorias = CategoriaReceta::all();

        //Agrupar las recetas por categorias
        $recetas = [];
        foreach ($categorias as $categoria) {
            $recetas[Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id)->take(3)->get();
        }
        return view('inicio.index', compact('nuevas_recetas', 'recetas', 'votadas'));
    }
}
