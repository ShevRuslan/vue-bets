<?php

namespace App\Http\Controllers\API;
;

use App\Models\Champ;
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
    protected $champ;
    private $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "X-Requested-With: XMLHttpRequest"
        )
    );
    public function __construct(Match $match, Player $player, Date $date, Champ $champ){
        $this->player = $player;
        $this->match = $match;
        $this->date = $date;
        $this->champ = $champ;
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
        $lastDate = $this->date->first();
        $dateArray = array();

        $i = 0;

        if(!$lastDate) {
            $lastDate = new Date();
            $lastDate['date'] = Carbon::now()->subDays($i)->format('Y-m-d');
            $lastDate->save();
        }
        
        while ($i != 15) {
            $tennis = array();
            
            $dateMatch = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateYear = Carbon::parse($dateMatch)->year;

            $lastDateSecond = strtotime($lastDate->date) * 1000;
            $dateMatchSecond = strtotime($dateMatch) * 1000;

            if($lastDateSecond < $dateMatchSecond) {
                $lastDate['date'] = $dateMatch;
                $lastDate->save();
            }

            $context = stream_context_create($this->opts);
            $url = json_decode(file_get_contents("https://1xstavka.ru/results/getMain?showAll=true&date={$dateMatch}", false, $context), true);
            $url = $url['results'];

            if(isset($url)) {
            
            foreach ($url as $sport) {
                if ($sport['Name'] == "Настольный теннис") {
                    $tennis = $sport;
                    break;
                }
            }

            foreach ($tennis['Elems'] as $match) {
                    foreach ($match['Elems'] as $match) {
                        $currentMatch = Match::where('idgame', $match['idgame'])->first();
                        $currentChamp = Champ::where('name', $match['champName'])->first();
                        if(!$currentChamp) {
                            $currentChamp = new Champ();
                            $currentChamp['name'] = $match['champName'];
                            $currentChamp->save();
                        }
                        $player1 = Player::where('name', $match['opp1'])->first();
                        if (!$player1) {
                            $player1 = new Player();
                            $player1['name'] = $match['opp1'];
                            $player1->save();
                        }
                        $player2 = Player::where('name', $match['opp2'])->first();
                        if (!$player2) {
                            $player2 = new Player();
                            $player2['name'] = $match['opp2'];
                            $player2->save();
                        }
                        if(!$currentMatch) {   
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
    
                          
                            $dateResMatch = Carbon::createFromFormat('d.m H:i', $match["date"]);
                            $dateMatchMonth = Carbon::parse($dateResMatch)->month;
                            $dateMonthSearch = Carbon::parse($dateMatch)->month;
                            $year = $dateYear;
                            if($dateMonthSearch < $dateMatchMonth) {
                                $year--;
                            }
    
                            $object["date"] = Carbon::createFromFormat('Y.d.m H:i', $year . '.' . $match["date"]);
                            $object["add_info"] = $match["add_info"];
                            $object["scores"] = $match["scores"][0];
                            $object->save();
                        }
                        if (isset($match['sub_games'])) {
                            $sub_games = $match['sub_games'];
                            foreach($sub_games as $sub_game) {
                                $currentSubMatch = Match::where('idgame', $sub_game["idgame"])->first();
                                if(!$currentSubMatch) {
                                    $dateResMatch = Carbon::createFromFormat('d.m H:i', $match["date"]);
                                    $dateMatchMonth = Carbon::parse($dateResMatch)->month;
                                    $dateMonthSearch = Carbon::parse($dateMatch)->month;
                                    $year = $dateYear;
                                    if($dateMonthSearch < $dateMatchMonth) {
                                        $year--;
                                    }
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
                                    $sub_object["idbetgames_main"] = $match["idgame"];
                                    $sub_object["opp1Country"] = $sub_game["opp1Country"] ?? null;
                                    $sub_object["opp2Country"] = $sub_game["opp2Country"] ?? null;
                                    $sub_object["dopScore"] = $sub_game["dopScore"] ?? null;
                                    $sub_object["IdSubGame"] = $match["IdSubGame"] ?? null;
                                    $sub_object["date"] = Carbon::createFromFormat('Y.d.m H:i', $year . '.' . $match["date"]) ?? null;
                                    $sub_object["add_info"] = $sub_game["games_info"] ? $sub_game["games_info"] : $match["add_info"];
                                    $sub_object["scores"] = $sub_game["Trslt_result"];
                                    $sub_object->save();
                                }
                            }
                        }
                    }
                }
        }
            $dateArray['day - ' . $i] = $dateMatch;
            $i++;
        }
        return response()->json($dateArray, 200);
    }
    public function update()
    {
        $lastDateObject = $this->date->first();
        $lastDate = $lastDateObject->date; //Дата последнего обновления

        $dateArray = array();

        $today = Carbon::now()->format('Y-m-d');
        $todayStr = Carbon::parse($today);

        //Если даты нет, то принимать текущую
        if(!$lastDate) {
            $lastDateObject = new Date();
            $lastDateObject['date'] = $today;
            $lastDateObject->save();
        }


        $dateArray['lastDay'] = $lastDate;

        //Количество пропущенных дней, за которые нужно найти матчи
        $i = $todayStr->diffInDays(Carbon::parse($lastDate)); 

        for($g = $i; $g != -1; $g--) {
        
            $today = Carbon::now()->subDays($g)->format('Y-m-d');
            $dateYear = Carbon::parse($today)->year;

            $dateArray["day - {$g}"] = $today; 
           

            $context = stream_context_create($this->opts);
            $url = json_decode(file_get_contents("https://1xstavka.ru/results/getMain?showAll=true&date={$today}", false, $context), true);

            $url = $url['results'];

            //Если за текущий день есть матчи, то обновить в бд последню дату и добавить матчи
            if(isset($url)){

                $dateArray['newLastDay'] = $today;
                // Сохранение в бд последней даты
                $lastDateObject['date'] = $today;
                $lastDateObject->save();
                
                // Отбираем только Настольный теннис
                foreach ($url as $sport) {
                    if ($sport['Name'] == "Настольный теннис") {
                        $tennis = $sport;
                        break;
                    }
                }
                //Рассматриваем все турниры -> матчи

                foreach ($tennis['Elems'] as $match) {
                    foreach ($match['Elems'] as $match) {
                        //Ищем матч по id
                        $currentMatch = $this->match->where('idgame', $match['idgame'])->first();
                        //Если такого матча нет - сохранять
                        if(!$currentMatch) {
                            //Ищем первого игрока
                            $player1 = $this->player->where('name', $match['opp1'])->first();
                            //Если его нет в бд - сохраняем
                            if (!$player1) {
                                $player1 = new Player();
                                $player1['name'] = $match['opp1'];
                                $player1->save();
                            }
                            //Ищем второго игрока
                            $player2 = $this->player->where('name', $match['opp2'])->first();
                            //Если его нет в бд - сохраняем
                            if (!$player2) {
                                $player2 = new Player();
                                $player2['name'] = $match['opp2'];
                                $player2->save();
                            }
                            //Сохраняем матч в бд
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
                            
                            $dateResMatch = Carbon::createFromFormat('d.m H:i', $match["date"]);
                            $dateMatchMonth = Carbon::parse($dateResMatch)->month;

                            $dateMonthSearch = Carbon::parse($today)->month;

                            $year = $dateYear;
                            if($dateMonthSearch < $dateMatchMonth) {
                                $year--;
                            }
                            $object["date"] = Carbon::createFromFormat('d.m H:i', $match["date"]);
                            $object["add_info"] = $match["add_info"];
                            $object["scores"] = $match["scores"][0];
                            $object->save();
                            //Если есть доп. игры по матчу - сохраняем в бд
                            if (isset($match['sub_games'])) {
                                $sub_games = $match['sub_games'];
                                foreach($sub_games as $sub_game) {
                                    $currentSubMatch = $this->match->where('idgame', $sub_game["idgame"])->first();
                                    if(!$currentSubMatch) {
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
                                        $sub_object["add_info"] = $match["games_info"] ?? null;
                                        $sub_object["scores"] = $sub_game["Trslt_result"];
                                        $sub_object->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $dateArray['after'] = $today;
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
    
        $countMatches = $request->countMatches;

        $player1 = $this->player->where('name', $request->player1)->first();

        $player2 = $this->player->where('name', $request->player2)->first();
        
        $game1 = $this->match->where('opp1', $player1->id)->where('opp2',$player2->id)->where('champName',$request->champName)->orderBy('date', 'desc')->get();

        $game2 = $this->match->where('opp1',$player2->id)->where('opp2',$player1->id)->where('champName',$request->champName)->orderBy('date', 'desc')->get();

        $wins = array(
            $player1->id => 0,
            $player2->id => 0,
        );
        $win1 = 0;
        $win2 = 0;
        $re = '/^\s*(?<masterBefore>\d+)\:(?<masterAfter>\d+)\s*/m';
        
        foreach($game1 as $obj){
            preg_match_all($re, $obj->scores, $matches, PREG_SET_ORDER, 0);
            $first = intval($matches[0]['masterBefore']);
            $second = intval($matches[0]['masterAfter']);
            if($obj->opp1 == $player1->id) {
                if($first > $second) {
                    $win1++;
                }
                else if($first < $second) {
                    $win2++;
                }
            }
            else {
                if($first > $second) {
                    $win2++;
                }
                else if($first < $second) {
                    $win1++;
                }
            }
        }
        foreach($game2 as $obj){
            preg_match_all($re, $obj->scores, $matches, PREG_SET_ORDER, 0);
            $first = intval($matches[0]['masterBefore']);
            $second = intval($matches[0]['masterAfter']);
            if($obj->opp2 == $player2->id) {
                if($first > $second) {
                    $win1++;
                }
                else if($first < $second) {
                    $win2++;
                }
            }
            else {
                if($first > $second) {
                    $win2++;
                }
                else if($first < $second) {
                    $win1++;
                }
            }
        }

        $last1  = $this->match->where('champName', $request->champName)->where(function($query) use($player1) {
            $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
        })->orderBy('date', 'desc')->take($countMatches)->get();
        
        $last2  = $this->match->where('champName', $request->champName)->where(function($query) use($player2) {
            $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
        })->orderBy('date', 'desc')->take($countMatches)->get();
        
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
            array(
                'mergeGames'=> $mergeArray, 
                'player1'=> $player1->name,
                'player2'=>$player2->name,
                'win1' => $win1, 
                'win2' => $win2
                )
        );

        return response()->json($array, 200);
    }

    public function searchTourney(Request $request)
    {

       return response()->json($this->match->where('champName', 'like', '%' . $request->champName . '%')->get()->unique('champName')->pluck('champName'), 200); 
    }
    public function getAllChamps(Request $request)
    {
        return $this->champ->all()->pluck('name');

    }
    public function getLastUpdateDate(Request $request) 
    {
        $lastDateObject = $this->date->first();
        return $lastDateObject->date;
    }
}
