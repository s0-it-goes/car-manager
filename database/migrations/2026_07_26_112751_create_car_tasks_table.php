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
        Schema::create('car_tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('car_id')
                ->constrained('cars')
                ->cascadeOnDelete();

            $table->enum('task', [
                'search_car',
                'invoice',
                'passport_copy',
                'snils',
                'inn',
                'contract',
                'import_explanation',
            ]);

            $table->enum('status', [
                'pending',
                'completed',
                'not_required',
            ])->default('pending');

            $table->timestamps();

            $table->unique(['car_id', 'task']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_tasks');
    }
};
