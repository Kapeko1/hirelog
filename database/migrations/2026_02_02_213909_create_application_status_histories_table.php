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
        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_application_id')->constrained()->onDelete('cascade');
            $table->string('from_status')->nullable(); // nullable for initial status
            $table->string('to_status');
            $table->timestamp('changed_at');
            $table->timestamps();

            // Indexes for performance
            $table->index('work_application_id');
            $table->index('changed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_status_histories');
    }
};
