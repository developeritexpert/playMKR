<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_management', function (Blueprint $table) {

            $table->id();

            $table->foreignId('deal_id')
                ->constrained('deals')
                ->cascadeOnDelete();

            $table->foreignId('sponsor_id')
                ->constrained('sponsors')
                ->cascadeOnDelete();

            $table->string('ticket_id')->unique();

            $table->string('ticket_name');

            $table->integer('number_of_tickets')->default(1);

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('ticket_type', [
                'VIP Pass',
                'General',
                'Backstage'
            ]);

            $table->enum('status', [
                'Pending',
                'Assigned',
                'Used'
            ])->default('Pending');

            $table->date('distribution_date')->nullable();

            $table->string('location')->nullable();

            $table->text('description')->nullable();

            $table->string('ticket_attachment')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_managements');
    }
};