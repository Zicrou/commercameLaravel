<?php

use App\Models\Type;
use App\Models\Produit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produit_type', function (Blueprint $table) {
            $table->foreignIdFor(Type::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Produit::class)->constrained()->cascadeOnDelete();
            $table->primary(['type_id', 'produit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_produit');
    }
};
