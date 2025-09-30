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
            $table->integer('external_id')->nullable()->unique(false)->change();
            $table->string('url')->nullable()->unique(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->integer('external_id')->nullable(false)->unique()->change();
            $table->string('url')->nullable(false)->unique()->change();
        });
    }
};
