<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
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

            //изображение в base64
            $table->text('image')->nullable();

            //автор
            $table->string('author')->nullable();

            //место проведения мероприятия
            $table->string('place')->nullable();

            //место проведения мероприятия
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
