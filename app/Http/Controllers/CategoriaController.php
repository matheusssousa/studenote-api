<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = Categoria::where('user_id', auth()->user()->id)->get();

        return response()->json($categoria, 200);
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
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = new Categoria();
        $categoria->nome = $request->nome;
        $categoria->cor = $request->cor;
        $categoria->user_id = auth()->user()->id;
        $categoria->save();

        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->user_id == auth()->user()->id) {
            return response()->json($categoria, 200);
        } else {
            return response()->json(['erro' => 'O registro buscado não existe ou não está disponível.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria, $id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->user_id != auth()->user()->id) {
            return response()->json(['erro' => 'Não foi possível efetuar a atualização, o registro buscado não existe.']);
        }

        $categoria->fill($request->all());
        $categoria->save();

        return response()->json($categoria, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria, $id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->user_id != auth()->user()->id) {
            return response()->json(['erro' => 'Não foi possível efetuar a exclusão, o registro buscado não existe.']);
        }

        $categoria->notas()->detach();
        $categoria->delete();

        return response()->json(['message' => 'Exclusão feita com sucesso'], 200);
    }
}
