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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedSmallInteger('total_days');
            $table->unsignedInteger('estimated_price');
            $table->date('actual_return_date')->nullable();
            $table->unsignedInteger('final_price')->nullable();
            $table->string('status', 30)->default('active'); // active | completed | cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
