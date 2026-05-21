<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliverables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained('deals')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('attachment')->nullable();
            // $table->enum('type', ['Post', 'Video', 'Campaign'])->default('Post');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliverables');
    }
};
