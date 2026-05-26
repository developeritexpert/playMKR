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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('deal_id')->constrained()->onDelete('cascade');
            $table->foreignId('sponsor_id')->constrained()->onDelete('cascade');
            $table->string('invoice_id')->unique();
            $table->string('invoice_title');
            $table->decimal('invoice_amount', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('currency')->default('USD');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->enum('payment_status', ['Pending','Paid','Overdue'])->default('Pending');
            $table->text('billing_address')->nullable();
            $table->string('contact_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
