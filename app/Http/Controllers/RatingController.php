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
            //$user = \Auth::user();
            /*$project = \App\Project::with('states', 'states.queries')->find($id);
            $categories = \App\Category::where('project_id', '=', $id)->with('states')->orderBy('name', 'ASC')->get();
            $uncat = \App\StarChatState::where('project_id', '=', $id)->whereNull('category_id')->select('id', 'name', 'bubble', 'category_id')->orderBy('name','ASC')->get();
            $states = \App\StarChatState::where('project_id', '=', $id)->select('id', 'name', 'bubble', 'category_id')->orderBy('name','ASC')->get();
            $bot = \App\GiosgBot::where('project_id', '=', $id)->first();
            return view('index', ['project'=>$project, 'states'=>$states, 'categories'=>$categories, 'uncat'=>$uncat, 'bot'=>$bot]);*/
            return view('index');
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
            $players = [];
            foreach($event->players as $player){
                // fetch player or create new
                $player->rating = 1500;
                $player->change = 0;
                $players[$player->name] = $player;
            }
            $games = [];
            foreach($event->rounds as $round){
                foreach($round->matches as $match){
                    array_push($games, $match);
                }
            }
            $this->calculateRating($players, $games, count($event->rounds));
            foreach($players as $player){
                if(isset($data['custom'])){
                    $player->rating += $player->change*(1+($player->sos*$player->mov/$rounds/100));
                }else{
                    $player->rating += $player->change; 
                }
                // SUM(pelien rating muutokset)*1+(SoS*MoV/games/100)
                //$modifier = 1 + ($player->sos*$player->mov/$rounds/100);
                //; 
            }
            return view('upload', ['players'=>$players]);
            /*$user = \Auth::user();
            $id = $user->project_id;
            $categories = \App\Category::where('project_id', '=', $id)->orderBy('name', 'ASC')->get();
            $project = \App\Project::find($id);
            return view('create-state', ['project'=>$project, 'categories'=>$categories]);*/
            //return view('upload');
        }
        
        private function calculateRating($players, $games){
            foreach($games as $game){
                /*
                $p1rating = $players[$game->player1]->rating;
                $p2rating = $players[$game->player2]->rating;
                $higher = $p1rating > $p2rating ? $p1rating : $p2rating;
                $lower = $p1rating < $p2rating ? $p1rating : $p2rating;
                $vf =  ($higher-$lower)/25;
                 */
                $p1points = $game->player1points;
                $p2points = $game->player2points;
                $winner = $p1points > $p2points ? $game->player1 : $game->player2;
                $loser = $p1points < $p2points ? $game->player1 : $game->player2;
                $vf = abs($players[$game->player1]->rating - $players[$game->player2]->rating)/25;
                if($vf > 15){$vf = 15;}
                $pts = 16+$vf;
                $players[$winner]->change += $pts;
                $players[$loser]->change -= $pts;
            }
        }
}
