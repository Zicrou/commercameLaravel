<?php

use App\Models\Produit;
use App\Models\User;
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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('designation')->nullable();
            $table->integer('nombre');
            $table->integer('prix');
            $table->boolean("statut")->default(true); // For deleteting update it to false
            $table->string('image')->nullable();
            $table->integer('produit_id')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            // $table->foreignIdFor(Produit::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
