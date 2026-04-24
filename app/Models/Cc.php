<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Cc extends Model
{
    protected $table = 'ccs';

    protected $fillable = ['nom'];

    public function ecoles(): HasMany
    {
        return $this->hasMany(Ecole::class, 'css_id');
    }

    public function postes(): HasManyThrough
    {
        return $this->hasManyThrough(Poste::class, Ecole::class, 'css_id', 'ecole_id');
    }
}
