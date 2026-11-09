<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('daily_reports', function (Blueprint $table): void { $table->text('work_summary')->nullable(); $table->text('challenges')->nullable(); $table->text('learning')->nullable(); $table->unsignedTinyInteger('rating')->nullable(); $table->text('reflection')->nullable(); $table->string('review_status', 20)->default('pending'); }); }
    public function down(): void { Schema::table('daily_reports', function (Blueprint $table): void { $table->dropColumn(['work_summary','challenges','learning','rating','reflection','review_status']); }); }
};
