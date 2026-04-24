<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use App\Models\Poste;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index(): JsonResponse
    {
        $matieres = Matiere::all();

        return response()->json([
            'data'    => $matieres,
        ]);
    }
    public function associer(Request $request, int $posteId): JsonResponse
    {
        $poste = Poste::find($posteId);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        $validated = $request->validate([
            'matiere_ids'   => 'required|array|min:1',
            'matiere_ids.*' => 'integer|exists:matieres,id',
        ]);

        $poste->matieres()->sync($validated['matiere_ids']);
        $poste->load('matieres');

        return response()->json([
            'message' => 'Matières associées avec succès.',
            'data'    => $poste->matieres,
        ]);
    }

    public function parPoste(int $posteId): JsonResponse
    {
        $poste = Poste::with('matieres')->find($posteId);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        return response()->json([
            'poste'   => $poste->nom,
            'data'    => $poste->matieres,
        ]);
    }
}
