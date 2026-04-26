<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Poste;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Contrôleur pour gérer les candidatures aux postes.
 */
class CandidatureController extends Controller
{
    /**
     * Liste les candidatures paginées avec les relations associées.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $candidatures = Candidature::with(['poste.ecole', 'personne'])
            ->paginate(10);

        return response()->json([
            'data' => $candidatures,
        ]);
    }

    /**
     * Crée une candidature pour un poste donné.
     *
     * @param Request $request Requête contenant les données de candidature.
     * @param int $posteId Identifiant du poste ciblé.
     * @return JsonResponse
     */
    public function store(Request $request, int $posteId): JsonResponse
    {
        $poste = Poste::find($posteId);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        $validated = $request->validate([
            'personne_id' => 'required|integer|exists:personnes,id',
            'statut' => 'sometimes|in:en_attente,accepte,refuse',
        ]);

        $existeDeja = Candidature::where('poste_id', $posteId)
            ->where('personne_id', $validated['personne_id'])
            ->exists();

        if ($existeDeja) {
            return response()->json([
                'message' => 'Cette personne a déjà soumis une candidature pour ce poste.',
            ], 422);
        }

        $candidature = Candidature::create([
            'poste_id' => $posteId,
            'personne_id' => $validated['personne_id'],
            'statut' => $validated['statut'] ?? 'en_attente',
        ]);

        $candidature->load(['poste.ecole', 'personne']);

        return response()->json([
            'message' => 'Candidature soumise avec succès.',
            'data' => $candidature,
        ], 201);
    }

    /**
     * Retourne toutes les candidatures associées à un poste.
     *
     * @param int $posteId Identifiant du poste.
     * @return JsonResponse
     */
    public function parPoste(int $posteId): JsonResponse
    {
        $poste = Poste::find($posteId);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        $candidatures = Candidature::with(['personne'])
            ->where('poste_id', $posteId)
            ->get();

        return response()->json([
            'poste' => $poste->nom,
            'data' => $candidatures,
        ]);
    }
}
