<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $table = 'albums';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments('id')->unique()->index();
            //название
            $table->string('title')->nullable();
            //описание
            $table->text('description')->nullable();
            //image src
            $table->string('poster')->nullable();
            //author
            $table->string('author')->nullable();
            //tags
            $table->json('tags')->nullable();
            //audio
            $table->json('audio')->nullable();

            $table->boolean('published')->default(false);

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
