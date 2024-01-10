<?php

namespace App\Http\Controllers;

use App\Models\ColorsPredefined;
use App\Http\Requests\StoreColorsPredefinedRequest;
use App\Http\Requests\UpdateColorsPredefinedRequest;

class ColorsPredefinedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = ColorsPredefined::all();

        return response()->json(['colors' => $colors], 200);
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
    public function store(StoreColorsPredefinedRequest $request)
    {
        $color = new ColorsPredefined();
        $color->cor_1 = $request->cor_1;
        $color->cor_2 = $request->cor_2;
        $color->cor_3 = $request->cor_3;
        $color->save();

        return response()->json(['message' => 'Cor criada com sucesso.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ColorsPredefined $colorsPredefined, $id)
    {
        $color = ColorsPredefined::find($id);

        return response()->json(['color' => $color], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ColorsPredefined $colorsPredefined)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorsPredefinedRequest $request, ColorsPredefined $colorsPredefined, $id)
    {
        $color = ColorsPredefined::find($id);
        $color->fill($request->all());
        $color->save();

        return response()->json(['message' => 'Cor alterada com sucesso.', 'cor' => $color], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ColorsPredefined $colorsPredefined, $id)
    {
        $color = ColorsPredefined::find($id);
        $color->delete();

        return response()->json(['message' => 'Cor excluida com sucesso.'], 200);
    }
}
