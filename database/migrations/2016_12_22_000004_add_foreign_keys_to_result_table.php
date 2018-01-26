<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToResultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('result', function(Blueprint $table)
            {
                $table->foreign('player_id')->references('id')->on('player')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('event_id')->references('id')->on('event')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('result', function(Blueprint $table)
            {
                $table->dropForeign('result_player_id_foreign');
                $table->dropForeign('result_event_id_foreign');
            });
	}

}
