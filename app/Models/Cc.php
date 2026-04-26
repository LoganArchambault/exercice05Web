<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Modèle représentant un centre de services scolaire.
 */
class Cc extends Model
{
    protected $table = 'ccs';

    /**
     * Attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nom'];

    /**
     * Retourne les écoles rattachées au centre.
     *
     * @return HasMany<Ecole, Cc>
     */
    public function ecoles(): HasMany
    {
        return $this->hasMany(Ecole::class, 'css_id');
    }

    /**
     * Retourne les postes liés au centre via les écoles.
     *
     * @return HasManyThrough<Poste, Ecole, Cc>
     */
    public function postes(): HasManyThrough
    {
        return $this->hasManyThrough(Poste::class, Ecole::class, 'css_id', 'ecole_id');
    }
}
