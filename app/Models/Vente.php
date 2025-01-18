<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nom', 'nombre', 'prix'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
