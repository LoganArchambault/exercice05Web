<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use App\Models\Poste;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Contrôleur pour gérer les matières et leur association aux postes.
 */
class MatiereController extends Controller
{
    /**
     * Liste toutes les matières.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $matieres = Matiere::all();

        return response()->json([
            'data' => $matieres,
        ]);
    }

    /**
     * Associe une ou plusieurs matières à un poste.
     *
     * @param Request $request Requête contenant les identifiants des matières.
     * @param int $posteId Identifiant du poste.
     * @return JsonResponse
     */
    public function associer(Request $request, int $posteId): JsonResponse
    {
        $poste = Poste::find($posteId);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        $validated = $request->validate([
            'matiere_ids' => 'required|array|min:1',
            'matiere_ids.*' => 'integer|exists:matieres,id',
        ]);

        $poste->matieres()->sync($validated['matiere_ids']);
        $poste->load('matieres');

        return response()->json([
            'message' => 'Matières associées avec succès.',
            'data' => $poste->matieres,
        ]);
    }

    /**
     * Retourne les matières associées à un poste.
     *
     * @param int $posteId Identifiant du poste.
     * @return JsonResponse
     */
    public function parPoste(int $posteId): JsonResponse
    {
        $poste = Poste::with('matieres')->find($posteId);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        return response()->json([
            'poste' => $poste->nom,
            'data' => $poste->matieres,
        ]);
    }
}
