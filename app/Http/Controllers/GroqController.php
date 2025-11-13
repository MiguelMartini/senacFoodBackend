<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucianoTonet\GroqPHP\Groq;

class GroqController extends Controller
{
    public function insightIA (){
        $user = Auth::user();
        // dd(env('GROQ_API_KEY'));
        $groq = new Groq(getenv('GROQ_API_KEY'));

        $respostaIa = null;
        try{
            $response = $groq->chat()->completions()->create([
                'model' => getenv('GROQ_MODEL'),
                'messages' => [
                    ['role' => 'system', 'content' => 'Você deve responder como um cozinheiro'],
                     ['role' => 'user', 'content' => 'Baseado nas receitas mais fáceis do Brasil, qual poderia ser um cárdapio rápido para ser feito no almoço?'],
                ],     
            ]);
            $respostaIa = $response['choices'][0]['message']['content'];
        } catch (\LucianoTonet\GroqPHP\GroqException $e){
            if(getenv('APP_DEBUG')) echo 'Error: ' . $e->getMessage();
            $respostaIa = 'IA indisponível';
        }
        
        return response()->json([
            'data' => $respostaIa
        ],200);
    }
}
