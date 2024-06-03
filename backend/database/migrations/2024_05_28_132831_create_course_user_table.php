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
        // nome tabella creata per forza in odine alfabetico e al singolare (si crea tutto più in fretta e laravel da una mano)
        Schema::create('course_user', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('status', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
};
