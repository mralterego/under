<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
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

            //изображение в base64
            $table->text('image')->nullable();

            //rubric
            $table->string('rubric')->nullable();

            //автор
            $table->string('author')->nullable();

            //место проведения мероприятия
            $table->string('place')->nullable();

            //tags
            $table->string('tags')->nullable();

            //rate
            $table->float('rate')->nullable();

            //rated persons
            $table->text('rated')->nullable();

            $table->boolean('isPublished')->nullable();

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
