<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use App\Http\Requests\StoreFavoritesRequest;
use App\Http\Requests\UpdateFavoritesRequest;
use App\Models\Notas;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorites::where('user_id', auth()->user()->id)->get();

        return response()->json(['favoritos' => $favorites], 200);
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
    public function store(StoreFavoritesRequest $request)
    {
        $nota = Notas::find($request->nota_id);

        
        if ($nota->annotation_community === 1 || $nota->user_id == auth()->user()->id) {
            // dd($nota);
            $favorite = new Favorites();
            $favorite->nota_id = $request->nota_id;
            $favorite->user_id = auth()->user()->id;
            $favorite->save();

            return response()->json(['message' => 'Adicionado aos favoritos com sucesso.'], 200);
        } else {
            return response()->json(['message' => 'Não foi possível fazer essa demanda.'], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorites $favorites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorites $favorites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoritesRequest $request, Favorites $favorites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorites $favorites, $id)
    {
        $favorites = Favorites::findOrFail($id);
        if ($favorites->user_id === auth()->user()->id) {
            $favorites->delete();
            return response()->json(['message' => 'Favorito escluído.'], 200);
        } else {
            return response()->json(['message' => 'Não foi possivel realizar essa ação.']);
        }
    }
}
