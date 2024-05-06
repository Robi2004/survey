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
        Schema::create('users_answers', function (Blueprint $table) {
            $table->foreignId('id_user')->constrained(table: 'users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_answer')->constrained(table: 'answers')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_answers');
    }
};
