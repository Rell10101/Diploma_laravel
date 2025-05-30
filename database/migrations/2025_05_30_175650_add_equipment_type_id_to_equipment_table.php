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
        Schema::table('equipment', function (Blueprint $table) {
            $table->unsignedBigInteger('equipment_type_id')->nullable(); // Добавляем поле equipment_type_id

            // Определяем внешний ключ
            $table->foreign('equipment_type_id')->references('id')->on('equipment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropForeign(['equipment_type_id']); // Удаляем внешний ключ
            $table->dropColumn('equipment_type_id'); // Удаляем поле
        });
    }
};
