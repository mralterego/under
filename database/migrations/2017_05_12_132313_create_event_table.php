<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    public $table = 'events';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments('id')->unique()->index();

            //заголовок
            $table->text('title')->nullable();

            //содержание
            $table->text('content')->nullable();

            //изображение ссылка
            $table->text('image')->nullable();

            //автор
            $table->string('author')->nullable();

            //место проведения мероприятия
            $table->string('place')->nullable();

            //ссылка на полное мероприятие
            $table->string('link')->nullable();

            //
            $table->string('price')->nullable();

            //время проведения мероприятия
            $table->string('date')->nullable();

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

