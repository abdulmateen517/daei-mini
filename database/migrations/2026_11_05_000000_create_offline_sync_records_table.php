<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offline_sync_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('client_id', 100);
            $table->string('type', 20);
            $table->json('data');
            $table->dateTime('original_created_at', 6);
            $table->dateTime('submitted_at', 6);
            $table->timestamps();

            $table->unique(['user_id', 'client_id']);
            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offline_sync_records');
    }
};
