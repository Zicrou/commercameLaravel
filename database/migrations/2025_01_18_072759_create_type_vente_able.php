<?php

use App\Models\Vente;
use App\Models\Type;
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
        // Add s or remove s to the table name
        Schema::create('type_vente', function (Blueprint $table) {
            $table->foreignIdFor(Type::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Vente::class)->constrained()->cascadeOnDelete();
            $table->primary(['type_id', 'vente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_vente');
    }
};
