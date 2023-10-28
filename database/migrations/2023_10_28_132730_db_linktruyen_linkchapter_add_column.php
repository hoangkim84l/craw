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
        Schema::table('link_truyens', function (Blueprint $table) {
            $table->string('type')->nullable()->after('status');
        });

        Schema::table('link_chapters', function (Blueprint $table) {
            $table->string('type')->nullable()->after('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('link_truyens', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('link_chapters', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
