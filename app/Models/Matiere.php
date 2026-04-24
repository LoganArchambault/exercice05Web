<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Matiere extends Model
{
    protected $fillable = ['nom'];

    public function postes(): BelongsToMany
    {
        return $this->belongsToMany(Poste::class, 'matiere_poste', 'matiere_id', 'poste_id');
    }
}
