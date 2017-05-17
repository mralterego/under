<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $connection = 'pgsql';

    protected $table = 'events';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'title', 'content', 'image', 'place', 'author', 'price', 'date', 'link', 'published', 'tags',
    ];

    protected $casts = [
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