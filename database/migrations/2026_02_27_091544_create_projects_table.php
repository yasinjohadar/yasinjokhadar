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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_category_id')->constrained('project_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('code_url')->nullable();
            $table->string('tags')->nullable(); // comma-separated technologies
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index(['project_category_id', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
