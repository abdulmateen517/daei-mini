<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20);
            $table->string('title');
            $table->dateTime('starts_at', 6);
            $table->boolean('reminder_enabled')->default(false);
            $table->dateTime('reminder_time', 6)->nullable();
            $table->unsignedSmallInteger('minutes_before')->nullable();
            $table->dateTime('reminder_at', 6)->nullable();
            $table->dateTime('reminder_sent_at', 6)->nullable();
            $table->timestamps();

            $table->index(['reminder_enabled', 'reminder_at', 'reminder_sent_at']);
            $table->index(['user_id', 'type', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_activities');
    }
};
