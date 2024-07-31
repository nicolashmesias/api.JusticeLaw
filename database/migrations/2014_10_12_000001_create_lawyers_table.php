<?php

use App\Models\Lawyer;
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
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->enum('document_type',[Lawyer::REGISTRO_CIVIL_DE_NACIMIENTO,Lawyer::TARJETA_DE_IDENTIDAD,Lawyer::CEDULA_CIUDADANIA,Lawyer::TARJETA_EXTRANJERIA,Lawyer::NIT,Lawyer::PASAPORTE])->default(Lawyer::CEDULA_CIUDADANIA)->nullable();
            $table->string('document_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};
