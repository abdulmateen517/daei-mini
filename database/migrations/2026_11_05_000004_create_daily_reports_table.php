<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('report_date');
            $table->unsignedInteger('total_activities')->default(0);
            $table->unsignedInteger('completed_activities')->default(0);
            $table->unsignedInteger('pending_activities')->default(0);
            $table->unsignedInteger('missed_activities')->default(0);
            $table->json('prayer_stats');
            $table->json('habit_stats');
            $table->json('activities');
            $table->dateTime('finalized_at', 6);
            $table->timestamps();

            $table->unique(['user_id', 'report_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
