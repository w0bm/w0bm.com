<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIcons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function(Blueprint $table) {
            $table->increments('id');
            $table->string('icon', 255);
            $table->string('icon_type', 255);
        });

        Schema::table('users', function(Blueprint $table) {
            $table->unsignedInteger('icon_id')->index()->nullable();
            $table->foreign('icon_id')
				->references('id')
				->on('icons')
				->onDelete('cascade');
        });

        Schema::table('roles', function(Blueprint $table) {
            $table->unsignedInteger('icon_id')->index()->nullable();
            $table->foreign('icon_id')
				->references('id')
				->on('icons')
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
        Schema::drop('icons');

        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('icon_id');
        });

        Schema::table('roles', function(Blueprint $table) {
            $table->dropColumn('icon_id');
        });
    }
}
