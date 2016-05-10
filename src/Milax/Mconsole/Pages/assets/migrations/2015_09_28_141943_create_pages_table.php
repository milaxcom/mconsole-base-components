<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->json('heading')->nullable();
            $table->json('preview')->nullable();
            $table->json('text')->nullable();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->boolean('hide_heading')->nullable();
            $table->boolean('fullwidth')->nullable();
            $table->boolean('system')->nullable();
            $table->boolean('enabled')->nullable();
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
        Schema::drop('pages');
    }
}
