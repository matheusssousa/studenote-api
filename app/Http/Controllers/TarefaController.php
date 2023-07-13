<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Http\Requests\StoreTarefaRequest;
use App\Http\Requests\UpdateTarefaRequest;
use App\Models\CategoriasTarefa;
use Illuminate\Support\Facades\DB;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarefa = Tarefa::all();

        return response()->json($tarefa, 200);
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
    public function store(StoreTarefaRequest $request)
    {
        $tarefa = new Tarefa();

        $tarefa->nome = $request->nome;
        $tarefa->descricao = $request->descricao;
        $tarefa->data_fim = $request->data_fim;
        $tarefa->disciplina_id = $request->disciplina_id;
        
        $tarefa->save();

        // ARMAZENA O ARRAY DE CATEGORIAS DO REQUEST EM $CATEGORIAS
        $categorias = $request->categorias;
        

        // LOOP PARA PERCORRER O ARRAY $CATEGORIAS E SALVAR NA TABELA CATEGORIASTABELAS
        foreach ($categorias as $key => $categoria) {
            CategoriasTarefa::create(['categoria_id' => $categoria, 'tarefa_id' => $tarefa->id]);
        }

        return response()->json($tarefa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {   
        //PARA CONSEGUIR AS INFORMAÇÕES DAS CATEGORIAS QUE CONTEM NA TAREFA
        $tarefa = Tarefa::with('categorias')->find($id);

        return response()->json($tarefa, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTarefaRequest $request, $id)
    {
        $tarefa = Tarefa::find($id);

        if ($tarefa === null) {
            return response()->json(['erro' => 'Não foi possível efetuar a atualização, o registro buscado não existe.']);
        }

        $tarefa->fill($request->all());
        $tarefa->save();

        // ARMAZENA O ARRAY DE CATEGORIAS DO REQUEST EM $CATEGORIAS
        $categorias = $request->categorias;

        // EXCLUI TODAS AS CATEGORIAS ASSOCIADAS A TAREFA NA TABELA CATEGORIASTAREFAS
        $tarefa->categorias()->detach();

        // Loop
        foreach ($categorias as $key => $categoria) {
            // RELACIONA AS NOVAS CATEGORIAS COM A TAREFA NA TABELA CATEGORIASTAREFAS
            $tarefa->categorias()->attach($categoria);  
        }
        
        return response()->json($tarefa, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tarefa = Tarefa::find($id);

        if ($tarefa === null) {
            return response()->json(['erro' => 'Não foi possível efetuar a exclusão, o registro buscado não existe.']);
        }

        // DELETA NA TABELA CATEGORIASTAREFAS PRIMEIRO PARA NÃO CAUSAR ERRO DE CHAVE ESTRANGEIRA
        $tarefa->categorias()->detach();

        $tarefa->delete();


        return response()->json(['message' => 'Exclusão feita com sucesso'], 200);
    }
}
