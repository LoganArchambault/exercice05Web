<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poste extends Model
{
    use HasFactory;

    protected $fillable = ['ecole_id', 'nom', 'description', 'charge'];

    public function ecole(): BelongsTo
    {
        return $this->belongsTo(Ecole::class, 'ecole_id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'poste_id');
    }

    public function matieres(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class, 'matiere_poste', 'poste_id', 'matiere_id');
    }
}
