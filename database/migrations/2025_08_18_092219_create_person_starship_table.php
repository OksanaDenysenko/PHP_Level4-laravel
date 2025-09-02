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
        Schema::create('person_starship', function (Blueprint $table) {
            $table->foreignId('person_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('starship_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['person_id', 'starship_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_starship');
    }
};
