<?php

use App\Models\Notification;
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

            $table->string('statement');
            $table->string('content');
            $table->string('status');
            $table->date('date');
            $table->enum('status', [Notification::READ, Notification::UNREAD])->default(Notification::UNREAD)->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lawyer_id')->nullable();


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
