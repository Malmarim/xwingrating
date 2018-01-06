<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStarchatQueryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('starchat_query', function(Blueprint $table)
            {
                $table->foreign('starchat_state_id')->references('id')->on('starchat_state')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('starchat_query', function(Blueprint $table)
            {
                $table->dropForeign('starchat_query_starchat_state_id_foreign');
            });
	}

}
