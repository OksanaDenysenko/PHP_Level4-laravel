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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->string('title',100);
            $table->tinyInteger('episode_id')->unsigned()->nullable();
            $table->text('opening_crawl');
            $table->string('director', 100);
            $table->string('producer');
            $table->date('release_date');
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
        Schema::dropIfExists('films');
    }
};
