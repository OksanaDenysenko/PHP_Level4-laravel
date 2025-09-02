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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->string('name',100);
            $table->smallInteger('rotation_period')->unsigned()->nullable();
            $table->smallInteger('orbital_period')->unsigned()->nullable();
            $table->integer('diameter')->unsigned()->nullable();
            $table->string('climate');
            $table->string('gravity');
            $table->string('terrain');
            $table->smallInteger('surface_water')->unsigned()->nullable();
            $table->bigInteger('population')->unsigned()->nullable();
            $table->dateTime('created',6);
            $table->dateTime('edited',6);
            $table->string('url')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};
