<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ecole extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'css_id'];

    public function css(): BelongsTo
    {
        return $this->belongsTo(Cc::class, 'css_id');
    }

    public function postes(): HasMany
    {
        return $this->hasMany(Poste::class, 'ecole_id');
    }
}
