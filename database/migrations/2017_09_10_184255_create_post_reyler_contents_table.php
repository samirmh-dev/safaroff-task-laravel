<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostReylerContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_reyler_content', function (Blueprint $table) {
            $table->increments('id');
            $table->text('rey');
	        $table->integer( 'fk_rey_id')->unsigned();
	        $table->foreign( 'fk_rey_id')
	              ->references('id')->on('post_reyler')
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
        Schema::dropIfExists('post_reyler_content');
    }
}
