<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('status', 20)->default('approved')->after('avatar');
            $table->string('student_email')->nullable()->after('student_name');
            $table->boolean('is_public_submission')->default(false)->after('is_active');

            $table->index('status');
        });

        DB::table('testimonials')->update(['status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'student_email', 'is_public_submission']);
        });
    }
};
