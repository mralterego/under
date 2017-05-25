<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collective extends Model
{

    protected $connection = 'pgsql';

    protected $table = 'collectives';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'alias', 'name', 'description', 'image', 'deputy', 'place', 'tags', 'social',
    ];

    protected $casts = [
        'tags' => 'array',
        'social' => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}