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
        Schema::create('starships', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->string('name');
            $table->string('model');
            $table->string('manufacturer');
            $table->bigInteger('cost_in_credits')->unsigned()->nullable();
            $table->bigInteger('length')->unsigned()->nullable();
            $table->string('max_atmosphering_speed');
            $table->double('crew')->nullable();
            $table->double('passengers')->nullable();
            $table->bigInteger('cargo_capacity')->unsigned()->nullable();
            $table->string('consumables');
            $table->float('hyperdrive_rating')->nullable();
            $table->smallInteger('MGLT')->unsigned()->nullable();
            $table->string('starship_class');
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
        Schema::dropIfExists('starships');
    }
};
