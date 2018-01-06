<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            $data = request()->all();
            $json = json_decode(file_get_contents($data['json']));
            return response()->json($json);            
            /*$user = \Auth::user();
            $id = $user->project_id;
            $categories = \App\Category::where('project_id', '=', $id)->orderBy('name', 'ASC')->get();
            $project = \App\Project::find($id);
            return view('create-state', ['project'=>$project, 'categories'=>$categories]);*/
            return view('upload');
        }
        
        public function postChat(){
            $data = json_decode(request()->getContent());
            ////$this->logWebhook("Chat", $data);
            if(!isset($data->resource)){
                //$this->log('Chat webhook error: missing parameter "resource"');
                return response()->json(['error'=>'missing parameter "resource"']);
            }
            $room = $data->resource->room_id;
            //$this->log("New chat. Room: ".$room." Channel: ".$data->channel." Id:".$data->resource_id);
            $org = $this->findId($data->channel);
            $bot = \App\GiosgBot::where('organization', '=', $org)->where('room_id', '=', $room)->first(); 
            
            if($bot == null && $org == '3e6e6580-30d0-11e3-a5d9-00163e0c01f2'){
                //$this->log("Bot null & com chat, joining as listener");
                $this->joinAsListener($org, $data);
                return 'ok';
            }else if($bot == null){
                Log::info("Bot null and not com, ignoring");
                return 'ok';
            }else{
                Log::info("Chat project: ".$bot->project_id);
            }
            
            $project = \App\Project::find($bot->project_id);
            $rand = rand(1,100);
            if($project->name == 'mehi-poc' && $rand > 50 && $this->isTeamOnline($bot, $bot->organization)){
                Log::info('Not joining: '.$rand);
                return 'ok';
            }
            $this->validateInvite($bot, $data);
            return 'ok';
        }
        
        public function postCreateState(Request $request){
            $this->validate($request, [
                'name' => 'required|alpha_dash',
                'bubble' => 'required',
            ]);
            
            $data = request()->all();
            $action_input = $this->parseActionInput($data);
            $analyzer = $this->encodeAnalyzer($data);
            $state = \App\StarChatState::create([
                'name'=>$data['name'],
                'bubble'=>$data['bubble'],
                'success_value'=>$data['success'],
                'failure_value'=>$data['failure'],
                'action'=>$data['action'],
                'action_input'=>$action_input,
                'project_id'=>$data['project'],
                'analyzer'=>$analyzer,
                'validation'=>strlen($data['validation']) >0 ? $data['validation'] : null,
                'category_id'=>$data['category']
            ]);
            if(isset($data['query'])){
                foreach($data['query'] as $query){
                    $this->createQuery($query, $state);
                }
            }
            $this->indexState($state);
            //$this->indexAnalyzer($state->project->starchat_url);
            return redirect()->action('ProjectController@getIndex', ['id'=>$data['project']]);
        }
        
        public function getIndexState($id){
            $state = \App\StarChatState::with('project', 'queries')->find($id);
            $errors = $this->indexState($state);
            //$errors['analyzer'] = $this->indexAnalyzer($state->project->starchat_url);
            return $this->indexState($state, $errors);
        }
        
        private function indexState($state, $errors = []){
            $query = $this->buildQuery($state);
            $url = $state->project->starchat_url.'/decisiontable';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            $result = curl_exec($ch);
            curl_close($ch);
            $errors[$state->name] = $result;
            return $errors;
        }
        
        public function getLoadFile($id = 1){
            $file = fopen(base_path().'/project'.$id.'.csv', 'r');
            $return = [];
            while (($line = fgets($file)) !== false) {
                $fields = explode(";", trim($line));
                $state = \App\StarChatState::firstOrCreate([
                    'name'=>$fields[0], 'bubble'=>$fields[4], 'action'=>$fields[5], 'action_input'=>$fields[6],
                    'project_id'=>$id, 'success_value'=>$fields[8], 'failure_value'=>$fields[9], 'validation'=>$fields[10]
                ]);
                $queries = json_decode($fields[3]);
                if($queries){
                    foreach($queries as $query){
                        \App\StarChatQuery::firstOrCreate(['text'=>$query, 'starchat_state_id'=>$state->id]);
                    }
                }
            }
            fclose($file);
            return $return;
        }
}
