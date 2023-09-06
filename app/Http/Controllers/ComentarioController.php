<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Http\Requests\StoreComentarioRequest;
use App\Http\Requests\UpdateComentarioRequest;
use App\Models\Notas;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(StoreComentarioRequest $request)
    {
        // Fazer somente se a anotação estiver habilitada para a comunidade.
        $nota = Notas::find($request->nota_id);

        if ($nota->annotation_community == 1) {
            $comentario = new Comentario;
            $comentario->comentario = $request->comentario;
            $comentario->nota_id = $request->nota_id;
            $comentario->user_id = auth()->user()->id;
    
            if ($request->comentario_pai) {
                $comentario->comentario_pai = $request->comentario_pai;
            }
    
            $comentario->save();

            return response()->json($comentario, 201);
        } else {
            return response()->json(['Erro' => 'Não foi possível registrar seu comentário.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario, $id)
    {
        $comentario = Comentario::find($id);

        return response()->json($comentario, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComentarioRequest $request, Comentario $comentario, $id)
    {
        $comentario = Comentario::find($id);

        if ($comentario === null || $comentario->user_id != auth()->user()->id) {
            return response()->json(['Erro' => 'O registro buscado não existe.']);
        }

        $comentario->fill($request->comentario);
        $comentario->save();

        return response()->json($comentario, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario, $id)
    {
        $comentario = Comentario::find($id);

        if (!$comentario || $comentario->user_id != auth()->user()->id) {
            return response()->json(['Erro' => 'O registro buscado não existe.']);
        }

        $comentario->delete();

        return response()->json(['Message' => 'Registro excluido com sucesso.'], 201);
    }
}
