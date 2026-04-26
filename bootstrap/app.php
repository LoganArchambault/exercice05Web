<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

/**
 * Point d'entrée de configuration de l'application Laravel.
 *
 * Ce fichier configure le routage, le middleware global et les réponses JSON
 * spécifiques aux erreurs API.
 */
return Application::configure(basePath: dirname(__DIR__))
    /**
     * Configure le routage de l'application, y compris l'API, les commandes et la santé.
     */
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    /**
     * Applique la limitation de débit aux routes API.
     */
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->throttleApi('60,1');
    })
    /**
     * Définit les réponses JSON personnalisées pour les exceptions API.
     */
    ->withExceptions(function (Exceptions $exceptions) {

        /**
         * Retourne une réponse JSON 404 pour les routes API introuvables.
         */
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'URL ne peut pas être trouvé.'
                ], 404);
            }
            return null;
        });

        /**
         * Retourne une réponse JSON 405 pour les méthodes HTTP non autorisées.
         */
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'La méthode spécifiée est invalide.'
                ], 405);
            }
            return null;
        });

        /**
         * Retourne une réponse JSON 422 pour les erreurs de validation API.
         */
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Validation échoué.',
                    'errors' => $e->errors()
                ], 422);
            }
            return null;
        });

        /**
         * Retourne une réponse JSON 429 lorsque la limite de requêtes est atteinte.
         */
        $exceptions->render(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Trop de requêtes. Veuillez patienter avant de réessayer.',
                    'retry_after' => $e->getHeaders()['Retry-After'] ?? null,
                ], 429);
            }
            return null;
        });

        /**
         * Retourne une réponse JSON 500 pour les erreurs inattendues de l'API.
         */
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Erreur : ' . $e->getMessage()
                ], 500);
            }
            return null;
        });
    })->create();
