<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use App\Http\Requests\StoreNotasRequest;
use App\Http\Requests\UpdateNotasRequest;
use App\Models\CategoriaNota;
use App\Models\FilesNotas;
use App\Models\LikeNota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nota = Notas::where('user_id', auth()->user()->id)->with('categorias', 'disciplina', 'files', 'comentarios', 'likes')->get();

        return response()->json($nota, 200);
    }

    /**
     * Buscar as notas mais recentes.
     */
    public function recentes()
    {
        $nota = Notas::where('user_id', auth()->user()->id)->with('categorias', 'disciplina', 'files', 'comentarios', 'likes')->orderByDesc('updated_at', 'created_at')->take(3)->get();

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
        $nota->annotation_community = $request->annotation_community;
        $nota->user_id = auth()->user()->id;

        $nota->save();

        $categorias = $request->categorias;
        foreach ($categorias as $key => $categoria) {
            CategoriaNota::create(['categoria_id' => $categoria, 'nota_id' => $nota->id]);
        }

        if ($request->file('arquivo')) {
            $arquivos = $request->file('arquivo');
            foreach ($arquivos as $key => $arquivo) {
                $arquivo_urn = $arquivo->store('arquivos', 'public');
                $arquivo_nome = $arquivo->getClientOriginalName();
                $arquivo_type = $arquivo->getClientOriginalExtension();
                FilesNotas::create(['arquivo' => $arquivo_urn, 'nome_arquivo' => $arquivo_nome, 'arquivo_type' => $arquivo_type, 'nota_id' => $nota->id]);
            }
        }

        return response()->json($nota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notas $notas, $id)
    {
        $nota = Notas::with('categorias', 'disciplina', 'files', 'likes')->find($id);

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
            return response()->json(['erro' => 'Não foi possível a atualização, o registro buscado não existe.']);
        }

        $nota->fill($request->all());
        $nota->save();

        if ($request->categorias) {
            $categorias = $request->categorias;
            // EXCLUI TODAS AS CATEGORIAS ASSOCIADAS A NOTA NA TABELA CATEGORIANOTA
            $nota->categorias()->detach();
            foreach ($categorias as $key => $categoria) {
                // RELACIONA AS NOVAS CATEGORIAS COM A NOTA NA TABELA CATEGORIANOTA
                $nota->categorias()->attach($categoria);
            }
        }

        // Vai mandar o request para gerenciarAtualizaçõesArquivos para verificar os arquivos.
        $this->gerenciarAtualizaçõesArquivos($request, $nota);

        return response()->json($nota, 200);
    }
    /**
     * Verificar as atualizações dos arquivos no request.
     */
    private function gerenciarAtualizaçõesArquivos($request, $nota)
    {
        $arquivos_novos = [];

        // Se existir arquivos no request ele irá verificar todos os arquivos, se não houver arquivos no request, ele irá excluir todos os arquivos.
        if ($request->hasFile('arquivo')) {
            foreach ($request->file('arquivo') as $key => $arquivo) {
                $arquivos_novos[] = $arquivo->getClientOriginalName();
            }
        }

        $arquivos_exists = $nota->files->pluck('nome_arquivo')->toArray();
        $arquivos_removes = array_diff($arquivos_exists, $arquivos_novos);

        $this->removerArquivos($nota, $arquivos_removes);
        $this->adicionarArquivos($request, $nota, $arquivos_novos, $arquivos_exists);
    }

    /**
     * Remover arquivos do storage e banco de dados.
     */
    private function removerArquivos($nota, $arquivos_removes)
    {
        $arquivos_remove = $nota->files()->whereIn('nome_arquivo', $arquivos_removes)->get('arquivo');

        // Se houver arquivos a serem excluidos, serão excluidos.
        if ($arquivos_remove) {
            foreach ($arquivos_remove as $key => $remove) {
                if (Storage::disk('public')->exists(($remove->arquivo))) {
                    Storage::disk('public')->delete($remove->arquivo);
                }
            }
            $nota->files()->whereIn('nome_arquivo', $arquivos_removes)->delete();
        }
    }

    /**
     * Adicionar novos arquivos no storage e banco de dados.
     */
    private function adicionarArquivos($request, $nota, $arquivos_novos, $arquivos_exists)
    {
        // Se houver novos arquivos a serem adicionados, serão adicionados.
        if ($arquivos_novos) {
            $arquivos = $request->file('arquivo');
            foreach ($arquivos as $key => $arquivo) {
                $arquivo_nome = $arquivo->getClientOriginalName();
                $arquivo_type = $arquivo->getClientOriginalExtension();
                // Verificar se o arquivo já existe antes de adicioná-lo novamente
                if (!in_array($arquivo_nome, $arquivos_exists)) {
                    $arquivo_urn = $arquivo->store('arquivos', 'public');
                    FilesNotas::create(['arquivo' => $arquivo_urn, 'nome_arquivo' => $arquivo_nome, 'arquivo_type' => $arquivo_type, 'nota_id' => $nota->id]);
                }
            }
        }
    }

    /**
     * Colocar nota na comunidade.
     */
    public function addComunidade(Request $request, $nota)
    {
        $nota = Notas::findOrFail($nota);

        if ($nota->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Não pode não.'], 201);
        }

        $nota->annotation_community = $request->annotation_community;
        $nota->save();

        if ($nota->annotation_community === '1') {
            return response()->json(['message' => 'Anotação adicionada na comunidade.']);
        } else {
            return response()->json(['message' => 'Anotação removida da comunidade.']);
        }
    }

    /**
     * Like em nota.
     */
    public function likeNote(Request $request, $nota)
    {
        $nota = Notas::findOrFail($nota);

        if ($request->like === 0) {
            return response()->json(["Isso aqui" => $request->like]);
        } else {
            return response()->json(["Não aqui" => $request->like]);
        }
        
        if ($nota->user_id === auth()->user()->id) {
            return response()->json(['message' => 'Por que você está querendo dar um like na sua nota?']);
        }
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

        foreach ($nota->files as $key => $file) {
            $url = $file->arquivo;
            if (Storage::disk('public')->exists(($url))) {
                Storage::disk('public')->delete($url);
            }
        }

        // Primeiramente é deletado na tabela CategoriaNota para não causar erro de chave entrangeira
        $nota->categorias()->detach();
        $nota->files()->delete();
        $nota->comentarios()->delete();
        $nota->likes()->delete();
        $nota->delete();

        return response()->json(['message' => 'Exclusão feita com sucesso'], 200);
    }
}
