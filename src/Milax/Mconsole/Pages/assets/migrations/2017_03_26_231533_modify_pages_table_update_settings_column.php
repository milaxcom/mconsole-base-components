<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPagesTableUpdateSettingsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('settings');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->json('settings')->nullable()->after('indexing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('settings');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->json('settings')->after('indexing');
        });
    }
}
