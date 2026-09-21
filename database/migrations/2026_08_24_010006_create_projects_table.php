<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['consultancy', 'construction', 'supply'])->default('consultancy');
            $table->string('client')->nullable();
            $table->string('location')->nullable();
            $table->string('period')->nullable(); // e.g. "2025 - 2026"
            $table->decimal('contract_amount', 14, 2)->nullable();
            $table->text('overview')->nullable();
            $table->json('scope')->nullable(); // bullet list
            $table->string('image_path')->nullable();
            $table->json('gallery')->nullable(); // array of paths
            $table->enum('status', ['ongoing', 'completed'])->default('ongoing');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
