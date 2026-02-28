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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained('course_sections')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('summary')->nullable();
            $table->text('content')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_preview')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['course_section_id', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
