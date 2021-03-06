<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
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
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('rating')->default(1500);
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
        Schema::drop('players');
    }
}
