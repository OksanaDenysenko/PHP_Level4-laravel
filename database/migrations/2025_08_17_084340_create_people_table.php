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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->string('name',100);
            $table->float('height')->unsigned()->nullable();
            $table->float('mass')->unsigned()->nullable();
            $table->string('hair_color', 50);
            $table->string('skin_color', 50);
            $table->string('eye_color', 50);
            $table->string('birth_year',50);
            $table->string('gender', 100);
            $table->dateTime('created',6);
            $table->dateTime('edited',6);
            $table->string('url')->unique();
            $table->foreignId('planet_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('species_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
