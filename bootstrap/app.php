<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // $exceptions->shouldRenderJsonWhen(function ($request, $e) {
        //     return true;
        // });
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'Não autenticado',
                    'message' => 'Token de autenticação inválido ou ausente.'
                ], 401);
            }
        });

        // Token Sanctum inválido ou sem permissão
        $exceptions->render(function (MissingAbilityException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'Token inválido',
                    'message' => 'O token fornecido é inválido ou não possui permissão.'
                ], 401);
            }
        });

        // Erros de validação
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'Falha',
                    'message' => $e->errors(),
                ], 422);
            }
        });

        // Model não encontrada (404)
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'Não encontrado',
                    'message' => 'O recurso solicitado não foi encontrado.'
                ], 404);
            }
        });

        // Erros inesperados (500)
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'Erro interno',
                    'message' => 'Ocorreu um erro inesperado no servidor.',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
        });
    })->create();
