<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deliverables', function (Blueprint $table) {
            if (Schema::hasColumn('deliverables', 'attachment')) {
                $table->dropColumn('attachment');
            }
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamp('status_updated_at')->nullable();
            $table->date('distribution_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('deliverables', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropForeign(['sponsor_id']);
            $table->dropForeign(['assigned_to']);
            $table->dropColumn([
                'task_id', 'sponsor_id', 'assigned_to',
                'status', 'status_updated_at',
                'distribution_date', 'priority', 'start_date', 'due_date',
            ]);
            $table->string('attachment')->nullable();
        });
    }
};