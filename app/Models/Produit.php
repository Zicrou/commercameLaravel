<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'nombre', 'montant', 'etat', 'image'];

    public function vente(): HasMany
    {
        return $this->hasMany(Vente::class);
    }
}
