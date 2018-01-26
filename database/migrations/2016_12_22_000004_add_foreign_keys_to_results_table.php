<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('results', function(Blueprint $table)
            {
                $table->foreign('player_id')->references('id')->on('players')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('event_id')->references('id')->on('events')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('results', function(Blueprint $table)
            {
                $table->dropForeign('results_player_id_foreign');
                $table->dropForeign('results_event_id_foreign');
            });
	}

}
