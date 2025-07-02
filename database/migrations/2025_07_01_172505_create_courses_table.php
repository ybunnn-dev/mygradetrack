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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->string('course_name');
            $table->unsignedTinyInteger('units'); // Using unsignedTinyInteger since units are typically small numbers
            $table->double('grade', 5, 2)->nullable(); // 5 digits total, 2 decimal places (e.g., 99.50)
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Index for better performance on semester_id since it will be used for lookups
            $table->index('semester_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};