<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('games', function(Blueprint $table)
            {
                $table->foreign('player_1_id')->references('id')->on('players')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('player_2_id')->references('id')->on('players')->onUpdate('CASCADE')->onDelete('CASCADE');
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
            Schema::table('games', function(Blueprint $table)
            {
                $table->dropForeign('games_player_1_id_foreign');
                $table->dropForeign('games_player_2_id_foreign');
                $table->dropForeign('games_event_id_foreign');
            });
	}

}
