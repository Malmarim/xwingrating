<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGameTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('game', function(Blueprint $table)
            {
                $table->foreign('player_1_id')->references('id')->on('player')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('player_2_id')->references('id')->on('player')->onUpdate('CASCADE')->onDelete('CASCADE');
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
            Schema::table('game', function(Blueprint $table)
            {
                $table->dropForeign('game_player_1_id_foreign');
                $table->dropForeign('game_player_2_id_foreign');
                $table->dropForeign('game_event_id_foreign');
            });
	}

}
