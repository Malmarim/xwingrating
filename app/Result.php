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

    public function venue(){
        return $this->belongsTo('App\Venue', 'venue_id', 'venue_id');
    }
    
    public function speakers(){
        return $this->belongsToMany('App\Speaker');
    }
    
    public function themes(){
        return $this->belongsToMany('App\Theme');
    }
    
    
}
