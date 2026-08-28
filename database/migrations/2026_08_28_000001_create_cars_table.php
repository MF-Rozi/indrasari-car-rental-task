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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->string('license_plate', 50)->unique();
            $table->unsignedInteger('daily_rate');
            $table->string('transmission', 20)->default('Automatic'); // Automatic | Manual
            $table->unsignedSmallInteger('seating_capacity')->default(5);
            $table->string('status', 30)->default('available'); // available | rented | maintenance
            $table->string('image_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
