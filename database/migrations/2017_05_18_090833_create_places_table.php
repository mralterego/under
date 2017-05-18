<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    public $table = 'places';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments('id')->unique()->index();

            //автор
            $table->string('alias')->nullable();

            //заголовок
            $table->text('title')->nullable();

            //содержание
            $table->text('description')->nullable();

            //изображение ссылка
            $table->string('image')->nullable();

            //ссылка на полное мероприятие
            $table->text('worktime')->nullable();

            //содержание
            $table->text('coordinates')->nullable();

            //ссылка на полное мероприятие
            $table->text('address')->nullable();

            //автор
            $table->string('deputy')->nullable();

            //автор
            $table->string('gallery')->nullable();

            //изображение ссылка
            $table->string('site')->nullable();

            //tags
            $table->json('tags')->nullable();

            //оценившие и оцнеки
            $table->json('rating')->nullable();

            //ссылка на полное мероприятие
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
