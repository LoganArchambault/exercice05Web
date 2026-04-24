<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidature extends Model
{
    protected $fillable = ['poste_id', 'personne_id', 'statut'];
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    public function personne(): BelongsTo
    {
        return $this->belongsTo(Personne::class, 'personne_id');
    }
}
