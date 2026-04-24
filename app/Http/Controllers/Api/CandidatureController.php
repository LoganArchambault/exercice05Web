<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Poste;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index(): JsonResponse
    {
        $candidatures = Candidature::with(['poste.ecole', 'personne'])
            ->paginate(10);

        return response()->json([
            'data'    => $candidatures,
        ]);
    }
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
            'statut'      => 'sometimes|in:en_attente,accepte,refuse',
        ]);

        // Empêcher les doublons : une personne ne peut postuler deux fois au même poste
        $existeDeja = Candidature::where('poste_id', $posteId)
            ->where('personne_id', $validated['personne_id'])
            ->exists();

        if ($existeDeja) {
            return response()->json([
                'message' => 'Cette personne a déjà soumis une candidature pour ce poste.',
            ], 422);
        }

        $candidature = Candidature::create([
            'poste_id'    => $posteId,
            'personne_id' => $validated['personne_id'],
            'statut'      => $validated['statut'] ?? 'en_attente',
        ]);

        $candidature->load(['poste.ecole', 'personne']);

        return response()->json([
            'message' => 'Candidature soumise avec succès.',
            'data'    => $candidature,
        ], 201);
    }
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
            'poste'   => $poste->nom,
            'data'    => $candidatures,
        ]);
    }
}
