<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostMetnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_metns', function (Blueprint $table) {
            $table->increments('id');
            $table->text('metn');
	        $table->integer('for_post')->unsigned()->unique();
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
        Schema::dropIfExists('post_metns');
    }
}
