<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostReylersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_reyler', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer( 'fk_user_id')->unsigned();
	        $table->foreign( 'fk_user_id')
	              ->references('id')->on('users')
	              ->onDelete('cascade');
            $table->integer( 'fk_post_id')->unsigned();
	        $table->foreign( 'fk_post_id')
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
        Schema::dropIfExists('post_reyler');
    }
}
