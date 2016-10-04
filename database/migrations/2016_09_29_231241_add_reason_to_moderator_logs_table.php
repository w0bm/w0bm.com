<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonToModeratorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderator_logs', function (Blueprint $table) {
            $table->string('reason')->nullable()->after('target_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderator_logs', function (Blueprint $table) {
            $table->dropColumn('reason');
        });
    }
}
