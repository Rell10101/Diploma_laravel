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
        Schema::create('simple_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('client_id');
            $table->timestamp('deadline');
            $table->string('priority');
            $table->unsignedBigInteger('executor_id');
            $table->string('status');

            // Определение внешних ключей
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('executor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simple_requests');
    }
};
