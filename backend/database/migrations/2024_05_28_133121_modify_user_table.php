<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image')->nullable();
            $table->string('role')->nullable();
            $table->string('genre')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->tinyInteger('course')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // eliminare le colonne
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_image')->nullable();
            $table->dropColumn('role')->nullable();
        });
    }
};
