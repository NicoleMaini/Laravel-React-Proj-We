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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('location', 150);
            $table->string('year', 4);
            // per creare la chiave esterna per la tabella relazionale

            // metodo 1 - da usare nel caso non avessimo seguito le convenzioni (nomi non in inglese, plurali dove non ci dovrebbero essere)
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');

            // metodo 2 - seguendo le convenzioni
            $table->foreignId('activity_id')->nullable()->constrained();
            $table->foreignId('slot_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // TODO: fix

        // $table->dropForeign('posts_user_id_foreign'); nome di default delle relazioni tra tabella
        // $table->dropForeign(['activity_id']);
        // $table->dropForeign(['slot_id']);
        Schema::dropIfExists('courses');
    }
};
