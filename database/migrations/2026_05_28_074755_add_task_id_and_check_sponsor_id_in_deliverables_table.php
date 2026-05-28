<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deliverables', function (Blueprint $table) {
            if (!Schema::hasColumn('deliverables', 'task_id')) {
                $table->string('task_id')->unique()->nullable()->after('id');
            }

            if (!Schema::hasColumn('deliverables', 'sponsor_id')) {
                $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->nullOnDelete()->after('task_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('deliverables', function (Blueprint $table) {
            if (Schema::hasColumn('deliverables', 'task_id')) {
                $table->dropColumn('task_id');
            }
        });
    }
};