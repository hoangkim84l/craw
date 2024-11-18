<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'site_title',
        'meta_desc',
        'meta_key',
        'story_id',
        'image_link',
        'audio_link',
        'show_img',
        'content',
        'status',
        'view',
        'author',
        'ordering',
        'created_at',
    ];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class, 'story_id');
    }

    public function nextChapter(): HasOne
    {
        return $this->hasOne(Chapter::class, 'story_id')
            ->where('created_at', '>', $this->created_at)
            ->orderBy('created_at');
    }

    public function previousChapter(): HasOne
    {
        return $this->hasOne(Chapter::class, 'story_id')
            ->where('created_at', '<', $this->created_at)
            ->orderBy('created_at', 'desc');
    }
}
