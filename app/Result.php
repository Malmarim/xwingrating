<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Result extends Model
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
    
    public function player(){
        return $this->belongsTo('App\Player');
    }
    
}
