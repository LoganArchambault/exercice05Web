<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Contrôleur pour gérer les centres de services scolaires.
 */
class CentreController extends Controller
{
    /**
     * Liste les centres avec filtre optionnel par nom.
     *
     * @param Request $request Requête contenant les filtres.
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Cc::withCount('postes');

        if ($request->has('nom')) {
            $query->where('nom', 'like', '%' . $request->input('nom') . '%');
        }

        $centres = $query->orderByDesc('postes_count')->get();

        return response()->json([
            'data' => $centres,
        ]);
    }

    /**
     * Retourne les statistiques des centres.
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        $stats = Cc::withCount('postes')
            ->with('ecoles')
            ->orderByDesc('postes_count')
            ->get()
            ->map(function (Cc $centre) {
                return [
                    'id' => $centre->id,
                    'nom' => $centre->nom,
                    'nb_ecoles' => $centre->ecoles->count(),
                    'nb_postes' => $centre->postes_count,
                ];
            });

        return response()->json([
            'data' => $stats,
        ]);
    }

    /**
     * Retourne les postes d'un centre.
     *
     * @param int $id Identifiant du centre.
     * @return JsonResponse
     */
    public function postes(int $id): JsonResponse
    {
        $centre = Cc::with(['postes.ecole', 'postes.matieres'])->find($id);

        if (!$centre) {
            return response()->json([
                'message' => 'Centre de services scolaire introuvable.',
            ], 404);
        }

        return response()->json([
            'centre' => $centre->nom,
            'data' => $centre->postes,
        ]);
    }
}
