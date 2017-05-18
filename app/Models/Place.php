<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{

    protected $connection = 'pgsql';

    protected $table = 'places';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'title', 'description', 'image', 'alias', 'deputy', 'gallery', 'address', 'coordinates', 'worktime', 'site', 'published', 'tags', 'rating',
    ];

    protected $casts = [
        'tags' => 'array',
        'rating' => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}