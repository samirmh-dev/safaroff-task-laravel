<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSehifeLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sehife_link', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('link');
	        $table->integer('fk_sehife_id')->unsigned();
	        $table->foreign( 'fk_sehife_id')
	              ->references('id')->on('sehifeler')
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
        Schema::dropIfExists('sehife_link');
    }
}
