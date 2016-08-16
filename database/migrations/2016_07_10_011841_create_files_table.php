<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('files', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('description')->nullable();
          $table->string('user_id');
          $table->string('status');
          $table->string('path');
          $table->string('extension');
          $table->string('real_path');
          $table->string('event_title')->nullable();
          $table->dateTime('event_date')->nullable();
          $table->string('place')->nullable();
          $table->string('type_id');
          $table->integer('album_id')->unsigned();
          $table->foreign('album_id')->references('id')->on('albums');
          $table->integer('author_id')->unsigned();
          $table->foreign('author_id')->references('id')->on('authors');
          $table->integer('area_id')->unsigned();
          $table->foreign('area_id')->references('id')->on('areas');
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
        Schema::drop('files');
    }
}
