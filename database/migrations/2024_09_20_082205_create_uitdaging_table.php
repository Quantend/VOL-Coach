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
        Schema::create('uitdagings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deelthema_id')->constrained()->onDelete('cascade');
            $table->enum('niveau', ['experimenteren', 'toepassen', 'verdiepen']);
            $table->json('opdrachten')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uitdagings');
    }
};
