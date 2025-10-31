<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_brand_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('year')->nullable();
            $table->enum('vehicle_type', ['sedan', 'suv', 'van', 'coupe', 'hatchback'])->default('sedan');
            $table->enum('fuel_type', ['petrol', 'electric', 'hybrid'])->default('petrol');
            $table->enum('transmission', ['manual', 'automatic'])->default('automatic');
            $table->integer('seats')->default(5);
            $table->integer('doors')->default(4);
            $table->string('engine_size')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
