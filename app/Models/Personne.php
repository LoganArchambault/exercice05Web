<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une personne candidate.
 */
class Personne extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nom', 'email'];

    /**
     * Retourne les candidatures soumises par la personne.
     *
     * @return HasMany<Candidature, Personne>
     */
    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'personne_id');
    }
}
