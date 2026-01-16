<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if ((int)$user->id !== (int) $id) {
            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Sem permissão para esta operação'
            ], 203);
        }
        return response()->json([
            'status' => 'Sucesso',
            'message' => $user->only(['id', 'name', 'email', 'perfil'])
        ], 200);
    }
    public function update(Request $request, string $id)
    {
        $authUser = Auth::user();

        if ((int) $authUser->id !== (int) $id) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Você não está autorizado para realizar esta operação'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'email' => 'sometimes|string|email',
            'perfil' => 'sometimes|string',
            'password' => 'required',
        ], [
            'password.required' => 'Senha obrigatória'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Senha inválida'
            ], 401);
        }

        $data = collect($validator->validated())->except('password')->toArray();

        $user->update($data);

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário atualizado com sucesso'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        if ((int)$user->id !== (int) $id) {
            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Sem permissão para esta operação'
            ], 203);
        }

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário deletado com suceeso'
        ], 200);
    }
}
