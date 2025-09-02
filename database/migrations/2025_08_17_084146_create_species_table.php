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
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->string('name',100);
            $table->string('classification');
            $table->string('designation');
            $table->smallInteger('average_height')->unsigned()->nullable();
            $table->string('skin_colors');
            $table->string('hair_colors');
            $table->string('eye_colors');
            $table->smallInteger('average_lifespan')->unsigned()->nullable();
            $table->string('language');
            $table->dateTime('created',6);
            $table->dateTime('edited',6);
            $table->string('url')->unique();
            $table->foreignId('planet_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
