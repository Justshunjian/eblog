<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEblogLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links',function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->increments('link_id');
            $table->string('link_name', 50)->default('')->comment('//名称');
            $table->string('link_title', 255)->default('')->comment('//标题');
            $table->string('link_url', 255)->default('')->comment('//链接');
            $table->integer('link_order')->defaut(0)->comment('//排序');;
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
        Schema::drop('links');
    }
}
