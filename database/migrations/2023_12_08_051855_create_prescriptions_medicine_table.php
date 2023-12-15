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
        Schema::create('prescriptions_medicine', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('medicine_id');
             $table->text('advice')->nullable();
            $table->text('note')->nullable();
            $table->string('timeOfDay')->nullable(); // Add the 'timeOfDay' column
            $table->string('whenTake')->nullable();  // Add the 'whenTake' column
            $table->integer('quantityPerDay')->nullable(); // Add the 'quantityPerDay' column
            $table->integer('duration')->nullable();
            $table->timestamps();

            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions_medicine');
    }
};
