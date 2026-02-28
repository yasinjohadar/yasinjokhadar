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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_title')->nullable();
            $table->string('course_name')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('quote');
            $table->string('avatar')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('is_active');
            $table->index('is_featured');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
