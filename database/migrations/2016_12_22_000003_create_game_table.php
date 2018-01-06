<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTable extends Migration
{
    /*
     * Peli: p1, p2, p1 score, p2 score, p1 rating change, p2 rating change
     */
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('player_1_id')->unsigned()->index('game_player_1_id_foreign');
            $table->bigInteger('player_2_id')->unsigned()->index('game_player_2_id_foreign');
            $table->bigInteger('event_id')->unsigned()->index('game_event_id_foreign');
            $table->tinyInteger('player_1_score');
            $table->tinyInteger('player_2_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game');
    }
}
