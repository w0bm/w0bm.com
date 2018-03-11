<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixDefaultValuesInFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // raw sql because doctrine/dbal doesn't support the timestamp datatype
        DB::statement("
            ALTER TABLE favorites
            MODIFY COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            MODIFY COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE favorites
            MODIFY COLUMN created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
            MODIFY COLUMN updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'
        ");
    }
}
