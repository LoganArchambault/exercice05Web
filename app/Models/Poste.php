<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant un poste d'enseignement.
 */
class Poste extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['ecole_id', 'nom', 'description', 'charge'];

    /**
     * Retourne l'école associée au poste.
     *
     * @return BelongsTo<Ecole, Poste>
     */
    public function ecole(): BelongsTo
    {
        return $this->belongsTo(Ecole::class, 'ecole_id');
    }

    /**
     * Retourne les candidatures reçues pour le poste.
     *
     * @return HasMany<Candidature, Poste>
     */
    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'poste_id');
    }

    /**
     * Retourne les matières associées au poste.
     *
     * @return BelongsToMany<Matiere>
     */
    public function matieres(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class, 'matiere_poste', 'poste_id', 'matiere_id');
    }
}
