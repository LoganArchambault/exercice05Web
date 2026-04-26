<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Contrôleur d'authentification pour la connexion, l'inscription et la déconnexion.
 */
class AuthController extends Controller
{
    /**
     * Authentifie un utilisateur et génère un jeton d'accès.
     *
     * @param Request $request Requête contenant les identifiants.
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects.'
            ], 401);
        }

        $token = $user->createToken('timetracker-token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token
        ]);
    }

    /**
     * Révoque le jeton d'accès courant de l'utilisateur authentifié.
     *
     * @param Request $request Requête de l'utilisateur connecté.
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        /** @var PersonalAccessToken|null $token */
        $token = $request->user()?->currentAccessToken();

        $token?->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    /**
     * Inscrit un nouvel utilisateur.
     *
     * @param Request $request Requête contenant les données d'inscription.
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Inscription réussie',
        ], 201);
    }
}
