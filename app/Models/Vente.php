<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nombre', 'prix', 'statut', 'produit_id', 'probleme'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    public function produits(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public static function getVentesGroupedByYearAndMonth()
    {
        return self::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'month')
            ->get();
    }
    
}
