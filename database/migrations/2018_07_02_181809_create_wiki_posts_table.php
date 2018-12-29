<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('wiki_id');
            $table->integer('user_id');
            $table->string('title');
            $table->text('body');
            $table->integer('visibility')->default(0); 
            $table->string('IP_address');
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
        Schema::dropIfExists('wiki_posts');
    }
}
