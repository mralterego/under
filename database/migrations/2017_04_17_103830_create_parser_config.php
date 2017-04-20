<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParserConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $table = 'parser_config';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments('id')->unique()->index();

            //alias
            $table->string('alias')->nullable();

            //url
            $table->string('url')->nullable();

            //url
            $table->string('place')->nullable();

            //alias
            $table->string('events_path')->nullable();

            //alias
            $table->string('title_path')->nullable();

            //ссылка
            $table->string('link_path')->nullable();

            //date
            $table->string('date_path')->nullable();

            //date
            $table->string('img_path')->nullable();

            //date
            $table->string('article_path')->nullable();

            //активен ли
            $table->boolean('isActive')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
