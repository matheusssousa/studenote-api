<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return response()->json(['message' => 'usuário criado com sucesso', 'user' => $user], 201);
    }

    public function update(UpdateUserRequest $request, $id)
{
    $user = User::find($id);

    if ($user === null) {
        return response()->json(['message' => 'Não foi possível fazer a atualização, usuário não encontrado.'], 404);
    }

    $user->fill($request->only(['name', 'email']));

    if ($request->has('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return response()->json(['message' => 'Usuário atualizado com sucesso', 'user' => $user], 200);
}

}
