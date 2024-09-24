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
            $table->unsignedBigInteger('user_id');
            $table->json('uitslag');
            $table->timestamps();

            $table->foreign('hoofdthema_id')->references('id')->on('hoofdthemas');
            $table->foreign('user_id')->references('id')->on('users');
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
