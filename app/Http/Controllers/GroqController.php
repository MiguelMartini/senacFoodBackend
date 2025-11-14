<?php

namespace App\Http\Controllers;

use App\Models\Ingredientes;
use App\Models\Receitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucianoTonet\GroqPHP\Groq;

class GroqController extends Controller
{
    public function insightPerfil()
    {
        $groq = new Groq(getenv('GROQ_API_KEY'));

        $user = Auth::user();
        $perfil = $user->perfil;

        $systemBase = ' Você é um Chef Executivo de alta gastronomia especializado em criar refeições equilibradas, saborosas e personalizadas. Seu objetivo é gerar uma saudação ao usuário e dar sugestões de refeições completas que incluam proteínas, carboidratos, legumes e/ou vegetais, com combinações harmoniosas e bem estruturadas.
                    RETORNE SEMPRE EXCLUSIVAMENTE UM JSON VÁLIDO, seguindo exatamente o formato:
                    {
                    "saudacao": ""    
                    },
                    {
                    "cafe_da_manha": {
                        "titulo": "",
                        "descricao": "",
                        "modo_preparo": "",
                        "tempo_preparo": ""
                    },
                    "almoco": {
                        "titulo": "",
                        "descricao": "",
                        "modo_preparo": "",
                        "tempo_preparo": ""
                    },
                    "jantar": {
                        "titulo": "",
                        "descricao": "",
                        "modo_preparo": "",
                        "tempo_preparo": ""
                    }
                    }

                    Não use texto fora do JSON.
                    Apenas o JSON puro.';


        if ($perfil !== null) {
            $userprompt = 'Baseado no meu perfil ' . $perfil . ' retorne as refeições em JSON.';
        } else {
            $userprompt = "Retorne sugestões de refeições completas com ingredientes comuns no dia a dia em JSON.";
        }

        try {
            $response = $groq->chat()->completions()->create([
                'model' => getenv('GROQ_MODEL'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemBase
                    ],
                    [
                        'role' => 'user',
                        'content' => $userprompt
                    ],
                ],
            ]);

            $json = $response['choices'][0]['message']['content'];
            $dados = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("A IA retornou um JSON inválido.");
            }

            $saudacao = $dados['saudacao'];
            $cafe = $dados['cafe_da_manha'];
            $almoco = $dados['almoco'];
            $jantar = $dados['jantar'];

            return response()->json([
                'saudacao' => $saudacao,
                'cafe_da_manha' => $cafe,
                'almoco'        => $almoco,
                'jantar'        => $jantar,
            ], 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json(['error' => 'IA indisponível'], 500);
        }
    }

    public function insightIngredientes()
    {
        $groq = new Groq(getenv('GROQ_API_KEY'));

        $user = Auth::user();
        $ingredientes = Ingredientes::where('user_id', $user->id)->get();

        $systemBase = ' Você é um Chef Executivo de alta gastronomia especializado em criar refeições equilibradas, saborosas e personalizadas. Seu objetivo é gerar uma saudação ao usuário e dar sugestões de refeições completas que incluam proteínas, carboidratos, legumes e/ou vegetais, com combinações harmoniosas e bem estruturadas.
                    RETORNE SEMPRE EXCLUSIVAMENTE UM JSON VÁLIDO, seguindo exatamente o formato:
                    {
                    "saudacao": ""    
                    },
                    {
                    "cafe_da_manha": {
                        "titulo": "",
                        "descricao": "",
                        "modo_preparo": "",
                        "tempo_preparo": ""
                    },
                    "almoco": {
                        "titulo": "",
                        "descricao": "",
                        "modo_preparo": "",
                        "tempo_preparo": ""
                    },
                    "jantar": {
                        "titulo": "",
                        "descricao": "",
                        "modo_preparo": "",
                        "tempo_preparo": ""
                    }
                    }

                    Não use texto fora do JSON.
                    Apenas o JSON puro.';


        if ($ingredientes->count() > 2) {
            $userprompt = 'Baseado nos meus ingredientes ' . $ingredientes . ' retorne as refeições em JSON.';
        } else {
            $userprompt = "Retorne sugestões de refeições completas com ingredientes comuns no dia a dia em JSON.";
        }

        try {
            $response = $groq->chat()->completions()->create([
                'model' => getenv('GROQ_MODEL'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemBase
                    ],
                    [
                        'role' => 'user',
                        'content' => $userprompt
                    ],
                ],
            ]);

            $json = $response['choices'][0]['message']['content'];
            $dados = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("A IA retornou um JSON inválido.");
            }

            $saudacao = $dados['saudacao'];
            $cafe = $dados['cafe_da_manha'];
            $almoco = $dados['almoco'];
            $jantar = $dados['jantar'];

            return response()->json([
                'saudacao' => $saudacao,
                'cafe_da_manha' => $cafe,
                'almoco'        => $almoco,
                'jantar'        => $jantar,
            ], 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json(['error' => 'IA indisponível'], 500);
        }
    }
    public function insightReceitas()
    {
        $groq = new Groq(getenv('GROQ_API_KEY'));

        $user = Auth::user();
        $receitas = Receitas::where('user_id', $user->id)->get();

        $systemBase = ' Você é um Chef Executivo de alta gastronomia especializado em criar refeições equilibradas, saborosas e personalizadas. Seu objetivo é gerar uma saudação ao usuário e dar sugestões de refeições completas que incluam proteínas, carboidratos, legumes e/ou vegetais, com combinações harmoniosas e bem estruturadas.
                    RETORNE SEMPRE EXCLUSIVAMENTE UM JSON VÁLIDO, seguindo exatamente o formato:
                    {
        "saudacao": "",
        "cafe_da_manha": {
            "titulo": "",
            "descricao": "",
            "modo_preparo": "",
            "tempo_preparo": ""
        },
        "almoco": {
            "titulo": "",
            "descricao": "",
            "modo_preparo": "",
            "tempo_preparo": ""
        },
        "jantar": {
            "titulo": "",
            "descricao": "",
            "modo_preparo": "",
            "tempo_preparo": ""
        }
    }

                    Não use texto fora do JSON.
                    Apenas o JSON puro.';


        if ($receitas->count() > 2) {
            $userprompt = 'Baseado nos meus ingredientes ' . $receitas . ' retorne as refeições em JSON.';
        } else {
            $userprompt = "Retorne sugestões de refeições completas com ingredientes comuns no dia a dia em JSON.";
        }

        try {
            $response = $groq->chat()->completions()->create([
                'model' => getenv('GROQ_MODEL'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemBase
                    ],
                    [
                        'role' => 'user',
                        'content' => $userprompt
                    ],
                ],
            ]);

            $json = $response['choices'][0]['message']['content'];
            $dados = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("A IA retornou um JSON inválido.");
            }

            $saudacao = $dados['saudacao'];
            $cafe = $dados['cafe_da_manha'];
            $almoco = $dados['almoco'];
            $jantar = $dados['jantar'];

            return response()->json([
                'saudacao' => $saudacao,
                'cafe_da_manha' => $cafe,
                'almoco'        => $almoco,
                'jantar'        => $jantar,
            ], 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json(['error' => 'IA indisponível'], 500);
        }
    }
}
