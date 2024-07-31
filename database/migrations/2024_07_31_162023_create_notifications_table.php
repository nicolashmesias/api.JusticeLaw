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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->string('enunciado');
            $table->string('contenido');
            $table->string('status');
            $table->date('date');
            $table->unsignedBigInteger('lawyer_id')->nullable();
            $table->enum('status', ['read', 'unread'])->default('pending');


            $table->foreign('user_id')
            ->references('id')
            ->on('users')->onDelete('cascade');



            $table->foreign('lawyer_id')
            ->references('id')
            ->on('lawyers')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
