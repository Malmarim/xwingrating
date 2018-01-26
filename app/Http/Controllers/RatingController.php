<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\DB;

class RatingController extends Controller {
    
        public function __construct()
	{
            $this->middleware('guest'); 
	}
        
        public function index(){
            $players = \App\Player::orderBy('rating', 'DESC')->get();
            return view('index', ['playes'=>$players]);
        }
        
        public function uploadPage(){
            return view('upload');
        }
        
        public function upload(){
            /*
            {
                "name": "Test",
                "players": [
                    {
                        "name": "Test",
                        "email": "",
                        "list-id": "",
                        "mov": 450,
                        "score": 2,
                        "sos": 0.22,
                        "dropped": 4,
                        "rank": {"swiss": 1}
                    },
                    {
                        "name": "Test 4",
                        "email": "",
                        "list-id": "",
                        "mov": 346,
                        "score": 2,
                        "sos": 0.67,
                        "dropped": 4,
                        "rank": {"swiss": 2}
                    },
                    {
                        "name": "Test 2",
                        "email": "",
                        "list-id": "",
                        "mov": 330,
                        "score": 2,
                        "sos": 0.44,
                        "dropped": 4,
                        "rank": {"swiss": 3}
                    },
                    {
                        "name": "Test 3",
                        "email": "",
                        "list-id": "",
                        "mov": 74,
                        "score": 0,
                        "sos": 0.67,
                        "dropped": 4,
                        "rank": {"swiss": 4}
                    }
                ],
                "rounds": [
                    {
                        "round-type": "swiss",
                        "round-number": 1,
                        "matches": [
                            {
                                "player1": "Test 2",
                                "player1points": 100,
                                "player2": "Test 3",
                                "player2points": 25,
                                "result": "win"
                            },
                            {
                                "player1": "Test",
                                "player1points": 97,
                                "player2": "Test 4",
                                "player2points": 98,
                                "result": "win"
                            }
                            ]
                    },
                    {
                        "round-type": "swiss",
                        "round-number": 2,
                        "matches": [
                            {
                                "player1": "Test 4",
                                "player1points": 100,
                                "player2": "Test 2",
                                "player2points": 0,
                                "result": "win"
                            },
                            {
                                "player1": "Test 3",
                                "player1points": 25,
                                "player2": "Test",
                                "player2points": 100,
                                "result": "win"
                            }
                        ]
                    },
                    {
                        "round-type": "swiss",
                        "round-number": 3,
                        "matches": [
                            {
                                "player1": "Test 4",
                                "player1points": 20,
                                "player2": "Test 2",
                                "player2points": 75,
                                "result": "win"
                            },
                            {
                                "player1": "Test",
                                "player1points": 100,
                                "player2": "Test 3",
                                "player2points": 24,
                                "result": "win"
                            }
                        ]
                    }
                ]
            }
            */
            $data = request()->all();
            $event = json_decode(file_get_contents($data['json']));
            $eModel = \App\Event::create(['name'=>$event->name]);
            $players = [];
            $pModels = [];
            foreach($event->players as $player){
                // fetch player or create new
                $p = \App\Player::where('name', $player->name)->firstOrCreate();
                $player->rating = $p->rating;
                $player->change = 0;
                $players[$player->name] = $player;
                \App\Result::create([
                    'player_id'=>$p->id,
                    'event_id'=>$eModel->id,
                    'sos'=>$player->sos,
                    'mov'=>$player->mov,
                    'score'=>$player->score,
                    'rank'=>$player->rank
                ]);
                $pModels[$player->name] = $p;
            }
            $games = [];
            foreach($event->rounds as $round){
                foreach($round->matches as $match){
                    \App\Game::create([
                        'round'=>$round->round-number,
                        'type'=>$round->round-type,
                        'player_1_id'=>$pModels[$match->player1]->id,
                        'player_2_id'=>$pModels[$match->player2]->id,
                        'event_id'=>$eModel->id,
                        'player_1_score'=>$match->player1points,
                        'player_2_score'=>$match->player2points,
                        'result'=>$match->result
                    ]);
                    array_push($games, $match);
                }
            }
            $this->calculateChange($players, $games);
            foreach($players as $player){
                $p = $pModels[$player->name];
                if(isset($data['custom'])){
                    $change = $player->change+($player->mov/200/count($event->rounds))*(count($event->players)/$player->rank->swiss)*$player->sos;
                    $player->rating += $change;
                }else{
                    $change = $player->change; 
                    $player->rating += $change;
                }
                \App\Result::where('player_id', $p->id)->where('event_id', $eModel->id)->update([
                   'change'=>$change 
                ]);
                $p->update([
                    'rating'=>$player->rating
                ]);                
            }
            return view('upload', ['players'=>$players]);
        }
        
        private function calculateChange($players, $games){
            foreach($games as $game){
                $p1points = $game->player1points;
                $p2points = $game->player2points;
                $winner = $p1points > $p2points ? $game->player1 : $game->player2;
                $loser = $p1points < $p2points ? $game->player1 : $game->player2;
                $winnerPoints = $p1points > $p2points ? $p1points : $p2points;
                $loserPoints = $p1points < $p2points ? $p1points : $p2points;
                $p1rating = $players[$game->player1]->rating;
                $p2rating = $players[$game->player2]->rating;
                $higher = $p1rating > $p2rating ? $game->player1 : $game->player2;
                $lower = $p1rating < $p2rating ? $game->player1 : $game->player2;
                $vf =  ($players[$higher]->rating-$players[$lower]->rating)/25;
                $diff = ($winnerPoints-$loserPoints)/100;
                if($vf > 15){$vf = 15;}
                $pts = $winner == $higher ? (16-$vf)*$diff : (16+$vf)*$diff;
                $players[$winner]->change += $pts;
                $players[$loser]->change -= $pts;
            }
        }
}
