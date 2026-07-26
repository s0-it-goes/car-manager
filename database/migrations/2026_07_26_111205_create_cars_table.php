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

            $table->foreignId('client_id')->constrained('clients');

            $table->enum('country', [
                'Japan',
                'Korea',
                'China'
            ]);

            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->integer('year')->nullable();
            $table->string('chassis_number', 100)->unique()->nullable();

            $table->enum('status', [
                'searching',
                'purchased',
                'waiting_departure',
                'in_transit',
                'arrived',
                'on_truck',
                'completed',
                'canceled'
            ])->default('searching');

            $table->text('notes')->nullable();

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
