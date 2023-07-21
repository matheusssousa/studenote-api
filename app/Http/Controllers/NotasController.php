<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use App\Http\Requests\StoreNotasRequest;
use App\Http\Requests\UpdateNotasRequest;
use App\Models\CategoriaNota;
use Mockery\Matcher\Not;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nota = Notas::where('user_id', auth()->user()->id)->get();

        return response()->json($nota, 200);
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
    public function store(StoreNotasRequest $request)
    {
        $nota = new Notas();

        $nota->nome = $request->nome;
        $nota->descricao = $request->descricao;
        $nota->data_prazo = $request->data_prazo;
        $nota->disciplina_id = $request->disciplina_id;
        $nota->user_id = auth()->user()->id;

        $nota->save();

        // ARMAZENA O ARRAY DE CATEGORIAS DO REQUEST EM $CATEGORIAS
        $categorias = $request->categorias;


        // LOOP PARA PERCORRER O ARRAY $CATEGORIAS E SALVAR NA TABELA CATEGORIASTABELAS
        foreach ($categorias as $key => $categoria) {
            CategoriaNota::create(['categoria_id' => $categoria, 'nota_id' => $nota->id]);
        }

        return response()->json($nota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notas $notas, $id)
    {
        $nota = Notas::with('categorias')->find($id);

        if ($nota->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Esse registro não existe.']);
        } else {
            return response()->json($nota, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notas $notas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotasRequest $request, Notas $notas, $id)
    {
        $nota = Notas::find($id);

        if ($nota === null || $nota->user_id != auth()->user()->id) {
            return response()->json(['erro' => 'Não foi possível efetuar a atualização, o registro buscado não existe.']);
        }

        $nota->fill($request->all());
        $nota->save();

        // ARMAZENA O ARRAY DE CATEGORIAS DO REQUEST EM $CATEGORIAS
        $categorias = $request->categorias;

        // EXCLUI TODAS AS CATEGORIAS ASSOCIADAS A NOTA NA TABELA CATEGORIANOTA
        $nota->categorias()->detach();

        // Loop
        foreach ($categorias as $key => $categoria) {
            // RELACIONA AS NOVAS CATEGORIAS COM A NOTA NA TABELA CATEGORIANOTA
            $nota->categorias()->attach($categoria);  
        }
        
        return response()->json($nota, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notas $notas, $id)
    {
        $nota = Notas::find($id);

        if ($nota === null || $nota->user_id != auth()->user()->id) {
            return response()->json(['erro' => 'Não foi possível efetuar a exclusão, o registro buscado não existe.']);
        }

        // DELETA NA TABELA CATEGORIANOTA PRIMEIRO PARA NÃO CAUSAR ERRO DE CHAVE ESTRANGEIRA
        $nota->categorias()->detach();

        $nota->delete();

        return response()->json(['message' => 'Exclusão feita com sucesso'], 200);
    }
}
