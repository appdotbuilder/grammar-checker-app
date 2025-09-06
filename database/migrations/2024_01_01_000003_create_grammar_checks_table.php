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
        Schema::create('grammar_checks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('school');
            $table->longText('original_text');
            $table->longText('corrected_text');
            $table->longText('suggestions');
            $table->integer('score')->default(100)->comment('Grammar score out of 100');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grammar_checks');
    }
};