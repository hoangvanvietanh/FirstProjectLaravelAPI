<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostsTable.
 */
class CreatePostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('url_image')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('username')->references('username')->on('users')
                ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}
}
