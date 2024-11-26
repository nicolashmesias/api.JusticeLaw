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
        Schema::create('lawyer_profiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')
            ->references('id')
            ->on('lawyers')->onDelete('cascade');

            $table->text('biography');
            $table->string('profile_photo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_profiles');
    }
};