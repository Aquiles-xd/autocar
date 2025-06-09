<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function loginAction(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function store(Request $request)
    {
        $array = [];
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $newUser = new User;
        $newUser->name = $data['name'];
        $newUser->email = $data['email'];
        $newUser->password = Hash::make($data['password']);
        $newUser->phone = $data['phone'];
        $newUser->save();


        $token = Auth::login($newUser);
        $array['token'] = $newUser->createToken('api-token')->plainTextToken;

        return response()->json($array, 200);
    }

    public function logout(Request $request)
{
    $user = $request->user();

    if (!$user || !$user->currentAccessToken()) {
        return response()->json(['error' => 'Usuário não autenticado'], 401);
    }

    // Deleta o token usado na requisição atual (efetivamente deslogando)
    $user->currentAccessToken()->delete();

    return response()->json(['message' => 'Logout realizado com sucesso'], 200);
}


}

