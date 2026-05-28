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
        // 1. Rename the Sponser Applications table
        if (Schema::hasTable('sponser_applications')) {
            Schema::rename('sponser_applications', 'sponsor_applications');
        }

        // 2. Rename the column in the sponsors table
        if (Schema::hasTable('sponsors') && Schema::hasColumn('sponsors', 'sponser_name')) {
            Schema::table('sponsors', function (Blueprint $table) {
                $table->renameColumn('sponser_name', 'sponsor_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sponsor_applications')) {
            Schema::rename('sponsor_applications', 'sponser_applications');
        }

        if (Schema::hasTable('sponsors') && Schema::hasColumn('sponsors', 'sponsor_name')) {
            Schema::table('sponsors', function (Blueprint $table) {
                $table->renameColumn('sponsor_name', 'sponser_name');
            });
        }
    }
};