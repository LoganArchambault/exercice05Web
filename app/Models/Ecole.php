<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une école.
 */
class Ecole extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nom', 'css_id'];

    /**
     * Retourne le centre de services scolaire de l'école.
     *
     * @return BelongsTo<Cc, Ecole>
     */
    public function css(): BelongsTo
    {
        return $this->belongsTo(Cc::class, 'css_id');
    }

    /**
     * Retourne les postes associés à l'école.
     *
     * @return HasMany<Poste, Ecole>
     */
    public function postes(): HasMany
    {
        return $this->hasMany(Poste::class, 'ecole_id');
    }
}
