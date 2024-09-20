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
        Schema::create('deelthemas', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->text('beschrijving')->nullable();
            $table->json('vragen');
            $table->text('content')->nullable();
            $table->foreignId('hoofdthema_id')->constrained()->onDelete('cascade');
            $table->string('media')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
