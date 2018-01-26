<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function event(){
        return $this->belongsTo('App\Event');
    }
    
    public function player1(){
        return $this->belongsTo('App\Player', 'player_1_id');
    }
    
    public function player2(){
        return $this->belongsTo('App\Player', 'player_2_id');
    }
    
}
