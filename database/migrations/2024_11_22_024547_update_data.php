<?php

use App\Models\Catalog;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('catalog', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Catalog::query()->chunkById(1000, function($catalogs) {
            foreach($catalogs as $catalog){
                $catalog->slug = Str::slug($catalog->name, '-');
                $catalog->save();
            }
        });

        Story::query()->chunkById(1000, function($stories) {
            foreach($stories as $story){
                $story->slug = Str::slug($story->name, '-');
                $story->created_at = $story->created;
                $story->save();
            }
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['created', 'updated']);
        });

        Chapter::query()->chunkById(1000, function($chapters) {
            foreach($chapters as $chap){
                $chap->slug = Str::slug($chap->name, '-');
                $chap->created_at = $chap->created;
                $chap->save();
            }
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->dropColumn(['created']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
