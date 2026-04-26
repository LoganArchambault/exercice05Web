<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modèle représentant une matière.
 */
class Matiere extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nom'];

    /**
     * Retourne les postes associés à la matière.
     *
     * @return BelongsToMany<Poste>
     */
    public function postes(): BelongsToMany
    {
        return $this->belongsToMany(Poste::class, 'matiere_poste', 'matiere_id', 'poste_id');
    }
}
