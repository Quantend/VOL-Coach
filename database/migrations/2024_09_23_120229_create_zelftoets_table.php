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
        Schema::create('zelftoets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hoofdthema_id');
            $table->unsignedBigInteger('deelthema_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('uitdaging_id');
            $table->json('uitslag');
            $table->timestamps();
            $table->foreign('hoofdthema_id')->references('id')->on('hoofdthemas');
            $table->foreign('deelthema_id')->references('id')->on('deelthemas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('uitdaging_id')->references('id')->on('uitdagings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uitslag');
    }
};
