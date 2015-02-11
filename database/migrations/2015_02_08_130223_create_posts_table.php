<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('posts',function(Blueprint $table){
            $table->increments('post_id');
            $table->string('post_title');
            $table->dateTime('post_date');
            $table->bigInteger('post_author');
            $table->longText('post_content');
            $table->string('post_status')->default('publish');
            $table->string('comment_status')->default('open');
            $table->integer('comment_count')->default('0');
            $table->tinyInteger('is_page')->default('0');
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
        Schema::dropIfExists(
            'posts'
        );
	}

}
