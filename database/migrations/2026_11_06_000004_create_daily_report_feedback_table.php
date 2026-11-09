<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('daily_report_feedback', function (Blueprint $table): void { $table->id(); $table->foreignId('daily_report_id')->constrained()->cascadeOnDelete(); $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); $table->text('comment'); $table->text('suggestions')->nullable(); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('daily_report_feedback'); }
};
