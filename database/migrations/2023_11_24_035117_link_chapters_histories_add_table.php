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
        Schema::create('link_chapters_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('link');
            $table->string('status')->nullable();
            $table->string('source')->nullable();
            $table->index('name');
            $table->index('link');
            $table->index('source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_chapters_histories');
    }
};
