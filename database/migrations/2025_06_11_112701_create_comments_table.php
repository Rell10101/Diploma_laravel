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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id'); 
            $table->foreign('request_id')
                ->references('id')->on('requests')
                ->onDelete('cascade'); 
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade'); 
            //$table->foreignId('request_id')->constrained()->onDelete('cascade'); // Внешний ключ на таблицу requests
            //$table->foreignId('user_id')->constrained()->onDelete('cascade'); // Внешний ключ на таблицу users
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
