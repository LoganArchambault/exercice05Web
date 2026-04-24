<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\JsonResponse;

class EcoleController extends Controller
{
    public function index(): JsonResponse
    {
        $ecoles = Ecole::with('css')->paginate(10);

        return response()->json([
            'data'    => $ecoles,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $ecole = Ecole::with(['css', 'postes'])->find($id);

        if (!$ecole) {
            return response()->json([
                'message' => 'École introuvable.',
            ], 404);
        }

        return response()->json([
            'data'    => $ecole,
        ]);
    }

    public function postes(int $id): JsonResponse
    {
        $ecole = Ecole::with(['postes.matieres'])->find($id);

        if (!$ecole) {
            return response()->json([
                'message' => 'École introuvable.',
            ], 404);
        }

        return response()->json([
            'data'    => $ecole->postes,
        ]);
    }
}
