<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerTable extends Migration
{
    /*
    Pelaaja: Nimi, rating, turnausten määrä, pelatut pelit, win%, lifetime mov, average sos
    Lopuksi laskee jokaiselle pelaajalle lopullisen rating changen. p1 rating change käyttää ennen turnauksen alkua ollutta ratingia.
    */
    
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('rating')->default(1500);
            $table->integer('tournaments')->default(0);
            $table->integer('games')->default(0);
            $table->integer('tournaments')->default(0);
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
        Schema::drop('player');
    }
}
