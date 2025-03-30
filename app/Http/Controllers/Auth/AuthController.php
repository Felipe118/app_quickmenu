<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusCode\StatusCodeEnum;
use App\Exceptions\Auth\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
      
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new AuthException(
        'Credenciais inválidas',
                  StatusCodeEnum::UNATHORIZED->value
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token'=> $token,
            'token_type'=> 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Deslogado com sucesso',
        ]);
    }
}
