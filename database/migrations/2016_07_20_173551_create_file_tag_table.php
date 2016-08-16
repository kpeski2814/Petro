<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('file_tag', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('file_id')->unsigned();
        $table->foreign('file_id')->references('id')->on('files');
        $table->integer('tag_id')->unsigned();
        $table->foreign('tag_id')->references('id')->on('tags');
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
        //
    }
}
