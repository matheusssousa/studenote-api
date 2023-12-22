<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

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
            'avatar' => 1,
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        event(new Registered($user));

        return response()->json(['message' => 'usuário criado com sucesso', 'user' => $user], 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->id != $id) {
            return response()->json(['message' => 'Acesso não autorizado'], 404);
        }

        $user->fill($request->only(['name', 'email', 'avatar']));
        $user->save();

        return response()->json(['message' => 'Usuário atualizado com sucesso', 'user' => $user], 200);
    }

    public function updatePassword(UpdatePasswordRequest $request, $id){
        $user = User::findOrFail($id);

        if (auth()->user()->id != $id) {
            return response()->json(['message' => 'Acesso não autorizado'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Senha alterada com sucesso.', 'user' => $user], 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(['user' => $user]);
    }

    public function showAll()
    {
        $user = User::all();

        return response()->json($user);
    }
}
