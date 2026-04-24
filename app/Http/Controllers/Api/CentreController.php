<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Cc::withCount('postes');

        // Filtrage par nom (insensible à la casse)
        if ($request->has('nom')) {
            $query->where('nom', 'like', '%' . $request->input('nom') . '%');
        }

        // Tri par ordre décroissant du nombre de postes
        $centres = $query->orderByDesc('postes_count')->get();

        return response()->json([
            'data'    => $centres,
        ]);
    }

    public function stats(): JsonResponse
    {
        $stats = Cc::withCount('postes')
            ->with('ecoles')
            ->orderByDesc('postes_count')
            ->get()
            ->map(function (Cc $centre) {
                return [
                    'id'           => $centre->id,
                    'nom'          => $centre->nom,
                    'nb_ecoles'    => $centre->ecoles->count(),
                    'nb_postes'    => $centre->postes_count,
                ];
            });

        return response()->json([
            'data'    => $stats,
        ]);
    }

    public function postes(int $id): JsonResponse
    {
        $centre = Cc::with(['postes.ecole', 'postes.matieres'])->find($id);

        if (!$centre) {
            return response()->json([
                'message' => 'Centre de services scolaire introuvable.',
            ], 404);
        }

        return response()->json([
            'centre'  => $centre->nom,
            'data'    => $centre->postes,
        ]);
    }
}
