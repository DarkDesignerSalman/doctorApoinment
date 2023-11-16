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
        Schema::create('doctor_details', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->string('doctor_name');
            $table->string('qualification');
            $table->string('department');
            $table->string('days_of_week');
            $table->string('branch');
            $table->string('image')->nullable(); // Add image column
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_details');
    }
};