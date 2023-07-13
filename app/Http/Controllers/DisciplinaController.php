<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Http\Requests\StoreDisciplinaRequest;
use App\Http\Requests\UpdateDisciplinaRequest;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disciplina = Disciplina::all();
        
        return response()->json($disciplina, 200);
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
    public function store(StoreDisciplinaRequest $request)
    {
        $disciplina = new Disciplina();
        $disciplina->nome = $request->nome;
        $disciplina->save();

        return response()->json($disciplina, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Disciplina $disciplina, $id)
    {
        $disciplina = Disciplina::find($id);

        return response()->json($disciplina, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disciplina $disciplina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisciplinaRequest $request, Disciplina $disciplina, $id)
    {
        $disciplina = Disciplina::find($id);

        if ($disciplina === null) {
            return response()->json(['erro' => 'Não foi possível efetuar a atualização, o registro buscado não existe.']);
        }

        $disciplina->fill($request->all());
        $disciplina->save();
        
        return response()->json($disciplina, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disciplina $disciplina, $id)
    {
        $disciplina = Disciplina::find($id);

        if ($disciplina === null) {
            return response()->json(['erro' => 'Não foi possível efetuar a exclusão, o registro buscado não existe.']);
        }

        $disciplina->delete();

        return response()->json(['message' => 'Exclusão feita com sucesso'], 200);
    }
}
