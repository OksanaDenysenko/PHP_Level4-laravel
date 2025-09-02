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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->string('name',100);
            $table->string('model');
            $table->string('manufacturer');
            $table->integer('cost_in_credits')->unsigned()->nullable();
            $table->double('length')->unsigned()->nullable();
            $table->integer('max_atmosphering_speed')->unsigned()->nullable();
            $table->smallInteger('crew')->unsigned()->nullable();
            $table->smallInteger('passengers')->unsigned()->nullable();
            $table->integer('cargo_capacity')->unsigned()->nullable();
            $table->string('consumables');
            $table->string('vehicle_class');
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
        Schema::dropIfExists('vehicles');
    }
};
