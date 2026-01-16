<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){ 

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'perfil' => 'sometimes',
            'password' => 'required|confirmed'
        ], [
            'name.require' => 'Nome obrigatório',
            'email.required' => 'E-mail obrigatório',
            'email.unique' => 'E-mail em uso',
            'password.required' => 'Senha obrigatória', 
            'password.confirmed' => 'Credenciais inváldias'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 403);
        }

        $data = $request->all();
        User::create($data);

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário criado com sucesso'
        ],200);
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json(['user' => Auth::user()], 200);
    }

    return response()->json([
        'status' => 'Falha',
        'message' => 'Erro'
        ], 401);
}

        public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
