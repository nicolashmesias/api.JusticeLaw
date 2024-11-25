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
        Schema::create('verification_lawyers', function (Blueprint $table) {
            $table->id();
            $table->string('cell_phone');

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');


            $table->enum('level', [
                'Universidad',
                'Maestría',
                'Doctorado'
            ])->default('Universidad');

            $table->string('training_place');

            $table->string('resume');

            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('id')->on('lawyers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_lawyers');
    }
};