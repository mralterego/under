<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $table = 'posts';
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

            //заголовок
            $table->text('title')->nullable();

            //содержание
            $table->text('content')->nullable();

            //изображение src
            $table->string('image')->nullable();

            //rubric
            $table->string('rubric')->nullable();

            //айди галереи
            $table->string('gallery')->nullable();

            //автор
            $table->string('author')->nullable();

            //tags
            $table->json('tags')->nullable();

            //rated persons
            $table->json('rating')->nullable();

            $table->boolean('published')->nullable();

            $table->timestamps();
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
