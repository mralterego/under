<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $table = 'messages';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments('id')->unique()->index();

            //содержание
            $table->text('content')->nullable();

            //автор
            $table->string('author')->nullable();

            //получатель
            $table->string('getter')->nullable();

            //комментарий ли
            $table->boolean('isComment')->default(false);

            //прочитан ли
            $table->json('isRead')->default(false);

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
