<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{

    protected $connection = 'pgsql';

    protected $table = 'albums';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'title', 'description', 'poster', 'author', 'audio', 'tags', 'published',
    ];

    protected $casts = [
        'json' => 'array',
        'tags' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}