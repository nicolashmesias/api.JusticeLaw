<?php

use App\Models\Information;
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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('body');
            $table->string('cover_photo');
            $table->enum('category',[Information::COMERCIAL,Information::LABORAL,Information::FAMILIAR,Information::PENAL,Information::CIVIL,Information::INMOBILIARIO])->default(Information::COMERCIAL)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
