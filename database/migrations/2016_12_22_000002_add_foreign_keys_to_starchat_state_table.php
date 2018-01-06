<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStarchatStateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('starchat_state', function(Blueprint $table)
            {
                $table->foreign('project_id')->references('id')->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('starchat_state', function(Blueprint $table)
            {
                $table->dropForeign('starchat_state_project_id_foreign');
            });
	}

}
