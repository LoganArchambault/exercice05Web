<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle représentant une candidature à un poste.
 */
class Candidature extends Model
{
    /**
     * Attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['poste_id', 'personne_id', 'statut'];

    /**
     * Retourne le poste lié à la candidature.
     *
     * @return BelongsTo<Poste, Candidature>
     */
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    /**
     * Retourne la personne ayant soumis la candidature.
     *
     * @return BelongsTo<Personne, Candidature>
     */
    public function personne(): BelongsTo
    {
        return $this->belongsTo(Personne::class, 'personne_id');
    }
}
