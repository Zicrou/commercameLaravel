<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'nombre', 'montant', 'etat'];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }
}
