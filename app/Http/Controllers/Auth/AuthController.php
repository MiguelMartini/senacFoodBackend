<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){ 
        $validator = Validator::make($request->all(),[
            'name' => 'requried',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6'
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
}
