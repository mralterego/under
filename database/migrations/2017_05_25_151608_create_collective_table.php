<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $table = 'collectives';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments('id')->unique()->index();

            //alias
            $table->string('alias')->nullable();

            //заголовок
            $table->text('name')->nullable();

            //содержание
            $table->text('description')->nullable();

            //изображение src
            $table->string('image')->nullable();

            //автор
            $table->string('deputy')->nullable();

            //место
            $table->string('place')->nullable();

            //tags
            $table->json('tags')->nullable();

            //автор
            $table->json('social')->nullable();

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
