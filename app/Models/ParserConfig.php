<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParserConfig extends Model
{

    protected $connection = 'pgsql';

    protected $table = 'parser_config';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'alias', 'url', 'events_path', 'title_path', 'link_path', 'date_path', 'img_path', 'article_path', 'isActive',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}