<?php

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
        Schema::create('film_species', function (Blueprint $table) {
            $table->foreignId('film_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('species_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['film_id', 'species_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_species');
    }
};
