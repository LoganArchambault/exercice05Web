<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personne extends Model
{
    protected $fillable = ['nom', 'email'];

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'personne_id');
    }
}
