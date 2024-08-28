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
        Schema::create('date_lawyer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('id')
            ->on('lawyers')->onDelete('cascade');
            $table->timestamps();

            $table->unsignedBigInteger('date_id');
            $table->foreign('date_id')->references('id')
            ->on('dates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_lawyer');
    }
};
