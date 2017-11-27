<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title2');
            $table->integer('for_post')->unsigned();
            $table->foreign( 'for_post')
	            ->references('id')->on('posts')
	            ->onDelete('cascade');
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
        Schema::dropIfExists('post_titles');
    }
}
