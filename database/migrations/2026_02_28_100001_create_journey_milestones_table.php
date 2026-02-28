<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journey_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journey_category_id')->constrained()->cascadeOnDelete();
            $table->string('year', 20);
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('journey_category_id');
            $table->index('is_active');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journey_milestones');
    }
};
