<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultTable extends Migration
{
    /*
     * Turnaus: Nimi (esim Ropecon 2017 tai Poro Store champ syksy 2017), pelit
    */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('player_id')->unsigned()->index('result_player_id_foreign');
            $table->bigInteger('event_id')->unsigned()->index('result_event_id_foreign');
            $table->integer('mov');
            $table->integer('score');
            $table->decimal('sos');
            $table->string('rank');
            $table->decimal('change')->default(0);
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
        Schema::drop('result');
    }
}
