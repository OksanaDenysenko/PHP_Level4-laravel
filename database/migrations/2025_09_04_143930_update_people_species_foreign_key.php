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
        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign(['species_id']);
            $table->foreign('species_id')->references('id')->on('species')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign(['species_id']);
            $table->foreign('species_id')->references('id')->on('species')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
