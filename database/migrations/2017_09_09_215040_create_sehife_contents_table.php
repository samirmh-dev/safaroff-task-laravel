<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSehifeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sehife_content', function (Blueprint $table) {
            $table->increments('id');
	        $table->text('content');
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
        Schema::dropIfExists('sehife_content');
    }
}
