<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('term_relationships',function(Blueprint $table){
            $table->bigInteger('post_id');
            $table->bigInteger('term_id');
            $table->bigInteger('order');
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
        Schema::dropIfExists('term_relationships');
	}

}
