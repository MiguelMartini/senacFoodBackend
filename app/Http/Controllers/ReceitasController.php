<?php

namespace App\Http\Controllers;

use App\Models\Receitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $receitas = Receitas::get();


        return response()->json([
            'user' => $user,
            'receita' => $receitas
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = Auth::user();

        try{
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'descricao' => 'required',
                'users_id'=> 'required',
                'favoritos_id' => 'required',
                'categoria_id' => 'required'
            ]);

        if(!$validator->fails()){
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 403);
        }
        
        $data = $request->all();
        Receitas::create($data);
        
        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Receita criada com sucesso'
        ],201);
    }catch(\Exception $e){
        return response()->json([
            'status'=> 'Falha',
            'message'=> $e->getMessage()
        ],500);}
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
