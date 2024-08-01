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
        Schema::create('overhaul_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id')->nullable();
            $table->unsignedBigInteger('administrators_id')->nullable();

            $table->foreign('review_id')
            ->references('id')
            ->on('reviews')->onDelete('cascade');

            $table->foreign('administrators_id')
            ->references('id')
            ->on('administrators')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overhaul_reviews');
    }
};
