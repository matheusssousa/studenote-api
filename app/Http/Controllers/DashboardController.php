<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Disciplina;
use App\Models\Notas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = [
            'Notas' => [
                'Total' => Notas::where('user_id', auth()->user()->id)->count(),
                'Com Arquivos' => Notas::where('user_id', auth()->user()->id)->has('files')->count(),
                'Com Datas' => Notas::where('user_id', auth()->user()->id)->whereNotNull('data_prazo')->count(),
            ],
            'UserComunidade' => [
                'Comunidade' => Notas::where('user_id', auth()->user()->id)->where('annotation_community', 1)->count(),
                'Com Likes' => Notas::where('user_id', auth()->user()->id)->has('likes')->count(),
                'Com Comentarios' => Notas::where('user_id', auth()->user()->id)->has('comentarios')->count(),
                'Com Mais Like' => Notas::select(['nome'])->where('user_id', auth()->user()->id)->withCount('likes')->orderByDesc('likes_count')->first(),
            ],
            'Categorias' => [
                'Total' => Categoria::where('user_id', auth()->user()->id)->count(),
                'CategoriaMaisNota' => Categoria::where('user_id', auth()->user()->id)->withCount('notas')->orderByDesc('notas_count')->first(),
            ],
            'Disciplina' => Disciplina::select(['nome'])->withCount('notas')->orderByDesc('notas_count')->first(),
            'Comunidade' => [
                'Populares' => Notas::where('annotation_community', 1)->withCount('likes')->orderByDesc('likes_count')->take(3)->get(),
            ],
        ];

        return response()->json($dados, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
