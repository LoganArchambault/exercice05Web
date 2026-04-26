<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\JsonResponse;

/**
 * Contrôleur pour gérer les écoles et leurs postes.
 */
class EcoleController extends Controller
{
    /**
     * Liste les écoles avec leur centre de services scolaire associé.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $ecoles = Ecole::with('css')->paginate(10);

        return response()->json([
            'data' => $ecoles,
        ]);
    }

    /**
     * Retourne le détail d'une école.
     *
     * @param int $id Identifiant de l'école.
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $ecole = Ecole::with(['css', 'postes'])->find($id);

        if (!$ecole) {
            return response()->json([
                'message' => 'École introuvable.',
            ], 404);
        }

        return response()->json([
            'data' => $ecole,
        ]);
    }

    /**
     * Retourne les postes d'une école avec leurs matières.
     *
     * @param int $id Identifiant de l'école.
     * @return JsonResponse
     */
    public function postes(int $id): JsonResponse
    {
        $ecole = Ecole::with(['postes.matieres'])->find($id);

        if (!$ecole) {
            return response()->json([
                'message' => 'École introuvable.',
            ], 404);
        }

        return response()->json([
            'data' => $ecole->postes,
        ]);
    }
}
