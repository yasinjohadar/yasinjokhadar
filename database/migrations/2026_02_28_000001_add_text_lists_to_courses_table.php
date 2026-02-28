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
        Schema::table('courses', function (Blueprint $table) {
            $table->text('highlights')->nullable()->after('meta_description');
            $table->text('learn_items')->nullable()->after('highlights');
            $table->text('requirements')->nullable()->after('learn_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['highlights', 'learn_items', 'requirements']);
        });
    }
};

