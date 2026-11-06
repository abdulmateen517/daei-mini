<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scheduled_activities', function (Blueprint $table): void {
            $table->dateTime('completed_at', 6)->nullable()->after('starts_at');
            $table->index(['user_id', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::table('scheduled_activities', function (Blueprint $table): void {
            $table->dropIndex(['user_id', 'starts_at']);
            $table->dropColumn('completed_at');
        });
    }
};
