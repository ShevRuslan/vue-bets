<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Match;
use App\Models\Player;
use App\Models\Date;
use Carbon\Carbon;

class MatchController extends Controller
{
    protected $rep;
    protected $match;
    protected $date;
    protected $player;
    private $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "X-Requested-With: XMLHttpRequest"
        )
    );
    public function __construct(Match $match, Player $player, Date $date){
        $this->player = $player;
        $this->match = $match;
        $this->date = $date;
    }


    public function createList()
    {
        $obj = $this->getCreateList();
        return response()->json($obj, 200);
    }

    public function search(Request $request)
    {
        $obj= $this->searchGame($request);
        return response()->json($obj, 200);
    }
    public function getCreateList()
    {
        $lastDate = $this->date->first()->date;
        $dateArray = array();
        if(!$lastDate) {
            $lastDate = new Date();
            $lastDate['date'] = Carbon::now()->subDays(0)->format('Y-m-d');
            $lastDate->save();
        }
        $today = Carbon::now()->format('Y-m-d');
        return $today;
        $i =0;
        while ($today != $lastDate) {
            $tennis = array();
            $dateMatch = Carbon::now()->subDays($i)->format('Y-m-d');

            $context = stream_context_create($this->opts);
            $url = json_decode(file_get_contents("https://1xstavka.ru/results/getMain?showAll=true&date={$dateMatch}", false, $context), true);
            $url = $url['results'];

            foreach ($url as $sport) {
                if ($sport['Name'] == "Настольный теннис") {
                    $tennis = $sport;
                    break;
                }
            }

            foreach ($tennis['Elems'] as $match) {
                foreach ($match['Elems'] as $match) {
                    $player1 = $this->player->where('name', $match['opp1'])->first();
                    if (!$player1) {
                        $player1 = new Player();
                        $player1['name'] = $match['opp1'];
                        $player1->save();
                    }
                    $player2 = $this->player->where('name', $match['opp2'])->first();
                    if (!$player2) {
                        $player2 = new Player();
                        $player2['name'] = $match['opp2'];
                        $player2->save();
                    }
                    $object = new Match();
                    $object["idgame"] = $match["idgame"];
                    $object["sportId"] = $match["sportId"];
                    $object["sportName"] = $match["sportName"];
                    $object["champId"] = $match["champId"];
                    $object["champName"] = $match["champName"];
                    $object["nameGame"] = $match["nameGame"];
                    $object["gameTyp"] = $match["gameTyp"];
                    $object["opp1"] = $player1->id;
                    $object["opp2"] = $player2->id;
                    $object["ResultPriority"] = $match["ResultPriority"];
                    $object["clid_opp1"] = $match["clid_opp1"] ?? null;
                    $object["clid_opp2"] = $match["clid_opp2"] ?? null;
                    $object["country"] = $match["country"];
                    $object["idbetgames_main"] = $match["idbetgames_main"];
                    $object["opp1Country"] = $match["opp1Country"] ?? null;
                    $object["opp2Country"] = $match["opp2Country"] ?? null;
                    $object["dopScore"] = $match["dopScore"] ?? null;
                    $object["IdSubGame"] = $match["IdSubGame"];
                    $object["date"] = Carbon::createFromFormat('d.m H:i', $match["date"]);;
                    $object["add_info"] = $match["add_info"];
                    $object["scores"] = $match["scores"][0];
                    $object->save();
                    if (isset($object['sub_games'])) {
                        $sub_game = $object['sub_games'];
                        $sub_object = new Match();
                        $sub_object["idgame"] = $sub_game["idgame"];
                        $sub_object["sportId"] = $sub_game["sportId"];
                        $sub_object["sportName"] = $sub_game["sportName"];
                        $sub_object["champId"] = $sub_game["champId"];
                        $sub_object["champName"] = $sub_game["champName"];
                        $sub_object["nameGame"] = $sub_game["nameGame"];
                        $sub_object["gameTyp"] = $match["gameTyp"];
                        $sub_object["opp1"] = $player1->id;
                        $sub_object["opp2"] = $player2->id;
                        $sub_object["ResultPriority"] = $sub_game["ResultPriority"];
                        $sub_object["clid_opp1"] = $sub_game["clid_opp1"] ?? null;
                        $sub_object["clid_opp2"] = $sub_game["clid_opp2"] ?? null;
                        $sub_object["country"] = $sub_game["country"];
                        $sub_object["idbetgames_main"] = $object["idgame"];
                        $sub_object["opp1Country"] = $sub_game["opp1Country"] ?? null;
                        $sub_object["opp2Country"] = $sub_game["opp2Country"] ?? null;
                        $sub_object["dopScore"] = $sub_game["dopScore"] ?? null;
                        $sub_object["IdSubGame"] = $match["IdSubGame"] ?? null;
                        $sub_object["date"] = Carbon::createFromFormat('d.m H:i', $match["date"]) ?? null;
                        $sub_object["add_info"] = $match["add_info"] ?? null;
                        $sub_object["scores"] = $sub_game["Trslt_result"];
                        $sub_object->save();
                    }
                }
            }
            $i++;
            $today = Carbon::now()->subDays($i)->format('Y-m-d');
        }
        return response()->json($dateArray, 200);
    }
    // Функция, которая возвращает последние 10 игр для каждого из игрока
    public function searchGame(Request $request)
    {
        $player1 = $this->player->where('name', $request->player1)->first();
        $player2 = $this->player->where('name', $request->player2)->first();

        //TODO:Делать провеку - если какой-то спортсмен не найден - выкидать ошибку
        $game1 = $this->match->where('opp1', $player1->id)->orWhere('opp2', $player1->id)->orderBy('date', 'desc')->take(10)->get();

        $game2 = $this->match->where('opp1', $player2->id)->orWhere('opp2', $player2->id)->orderBy('date', 'desc')->take(10)->get();

        $array = array(
            array(
                'id' => $player1->id,
                'name' => $player1->name,
                'matches' => $game1,
            ),
            array(
                'id' => $player2->id,
                'name' => $player2->name,
                'matches' => $game2,
            ),
        );

        return response()->json($array, 200);
    }
    //Поиск спортсмена
    public function getSporstsmen (Request $request) 
    {
        //TODO: Проверка на пустоту
        $name = $request->name;
        $player = $this->player->where('name', 'like', '%' . $name . '%')->get();
        return response()->json($player, 200);
    }

    public function commonMatch(Request $request)
    {
    
        $player1 = $this->player->where('name', $request->player1)->first();

        $player2 = $this->player->where('name', $request->player2)->first();
        
        $game1 = $this->match->where('opp1', $player1->id)->where('opp2',$player2->id)->where('champName',$request->champName)->get();

        $game2 = $this->match->where('opp1',$player2->id)->where('opp2',$player1->id)->where('champName',$request->champName)->get();
        $win1 =0;
        $win2 =0;
        foreach($game1 as $obj){
            $scores1 = mb_strimwidth($obj->scores,0,1);
            $scores2 = mb_strimwidth($obj->scores,2,1);
            if($scores1 > $scores2){
                $win1++;
            }else{
                $win2++;
            }
        }
        foreach($game2 as $obj){
            $scores1 = mb_strimwidth($obj->scores,0,1);
            $scores2 = mb_strimwidth($obj->scores,2,1);
            if($scores1 > $scores2){
                $win1++;
            }else{
                $win2++;
            }
        }

        $last1  = $this->match->where('champName', $request->champName)->where(function($query) use($player1) {
            $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
        })->orderBy('date', 'desc')->take(10)->get();
        
        $last2  = $this->match->where('champName', $request->champName)->where(function($query) use($player2) {
            $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
        })->orderBy('date', 'desc')->take(10)->get();
        
        $mergeArray = collect($game1)->merge($game2);


        $array = array(
            array(
                'id' => $player1->id,
                'name' => $player1->name,
                'matches' => $last1, 
            ),
            array(
                'id' => $player2->id,
                'name' => $player2->name,
                'matches' => $last2,
            ),
            array('games'=> array($game1, $game2) ),
            array('mergeGames'=> $mergeArray),
            array('win1'=>$win1,
                  'win2'=>$win2    
            )
        );

        return response()->json($array, 200);
    }

    public function searchTourney(Request $request)
    {

       return response()->json($this->match->where('champName', 'like', '%' . $request->champName . '%')->get()->unique('champName')->pluck('champName'), 200); 
    }
}
