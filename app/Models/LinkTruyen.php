<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkTruyen extends Model
{
    use HasFactory;

    public const STATUS_PROCESS = 'IN PROCESS';
    public const STATUS_DONE = 'DONE';
    public const STATUS_NOT_FOUND = 'TITLE CHANGE, CAN NOT FIND THE ORG STORY';

    public const TYPE_TF = 'TF';
    public const TYPE_DT = 'DT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'link',
        'status',
        'type',
    ];

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
}
