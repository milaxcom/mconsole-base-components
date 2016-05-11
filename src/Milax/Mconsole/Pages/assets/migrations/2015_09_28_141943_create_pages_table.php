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
            $table->boolean('hide_heading')->default(false);
            $table->boolean('fullwidth')->default(false);
            $table->boolean('system')->default(false);
            $table->boolean('enabled')->default(true);
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
