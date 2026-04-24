<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Poste;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PosteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Poste::with(['ecole.css', 'matieres']);

        if ($request->has('charge_min')) {
            $query->where('charge', '>=', (float) $request->input('charge_min'));
        }

        if ($request->has('charge_max')) {
            $query->where('charge', '<=', (float) $request->input('charge_max'));
        }

        if ($request->has('ecole_id')) {
            $query->where('ecole_id', $request->input('ecole_id'));
        }

        $postes = $query->paginate(10);

        return response()->json([
            'data'    => $postes,
        ]);
    }
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ecole_id'    => 'required|integer|exists:ecoles,id',
            'nom'         => 'required|string|max:255',
            'description' => 'required|string',
            'charge'      => 'required|numeric|min:0|max:100',
        ]);

        $poste = Poste::create($validated);
        $poste->load(['ecole.css', 'matieres']);

        return response()->json([
            'message' => 'Poste créé avec succès.',
            'data'    => $poste,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $poste = Poste::with(['ecole.css', 'matieres', 'candidatures.personne'])->find($id);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        return response()->json([
            'data'    => $poste,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $poste = Poste::find($id);

        if (!$poste) {
            return response()->json([
                'message' => 'Poste introuvable.',
            ], 404);
        }

        $poste->delete();

        return response()->json([
            'message' => 'Poste supprimé avec succès.',
        ]);
    }
}
