<?php

namespace App\Http\Controllers\API;

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
    public function __construct(Match $match, Player $player, Date $date, Champ $champ)
    {
        $this->player = $player;
        $this->match = $match;
        $this->date = $date;
        $this->champ = $champ;
    }
    //Получение общих соперников и матчей с ними
    public function getCommonRivals(Request $request)
    {
        $countMatchesRivals = $request->countMatches; //Количество матчей для общих соперников
        $champName = $request->champName;  //Чемпионат
        $line = $request->line ?? false; // Флаг на матч из линии
        $playersMatches = $this->getMatchesSportsmen($request->player1, $request->player2, $champName, null, null, $line, false);
        $commonRivalsMatches = $this->getEqualPlayers($playersMatches[0], $playersMatches[1], null, $countMatchesRivals, $line);
        return response()->json($commonRivalsMatches, 200);
    }
    public function update(Request $request) {
        $arrayTimes = [];
        for ($i = 0; $i != -1; $i--) {
            $dateMatch = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateYear = Carbon::parse($dateMatch)->year;
            $lastDateUpdate = Date::first();
            $tennis = array();

            if(!$lastDateUpdate) {
                $lastDateUpdate = new Date();
            }

            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "X-Requested-With: XMLHttpRequest"
                )
            );
            $context = stream_context_create($opts);
            $response = null;
            $countRequest = 1;
            while(true) {
                $req = @file_get_contents("https://1xstavka.ru/results/getMain?showAll=true&date={$dateMatch}", false, $context);
                if($req !== FALSE) {
                    $url = json_decode($req, true);
                    $response = $url['results'];
                    break;
                }
                else {
                    $countRequest++;
                    if($countRequest == 20) {
                         break;
                    };
                    sleep(1);
                    continue;
                }
            }
            
            if(isset($response)) {
            
                foreach ($response as $sport) {
                    if ($sport['Name'] == "Настольный теннис") {
                        $tennis = $sport;
                        break;
                    }
                }
                try {
                    foreach ($tennis['Elems'] as $match) {
                        foreach ($match['Elems'] as $match) {
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
                            if (isset($match['sub_games'])) {
                                $sub_games = $match['sub_games'];
                                foreach($sub_games as $sub_game) {
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
                    array_push($arrayTimes, $dateMatch);
                }
                catch(Exception $e) {
                    continue;
                }
                
                $lastDateUpdate->date = Carbon::now()->format('Y.d.m H:i');
                $lastDateUpdate->save();
            }
    }
    return response()->json($arrayTimes, 200);
}
    
    //Поиск спортсмена
    public function getSporstsmen(Request $request)
    {
        // $arrayTimes = [];
        // for ($i = 15; $i != -1; $i--) {
        //     $dateMatch = Carbon::now()->subDays($i)->format('Y-m-d');
        //     array_push($arrayTimes, $dateMatch);
        //     $lastDateUpdate = Date::first();
        //     $tennis = array();
        //     $dateYear = Carbon::parse($dateMatch)->year;
        //     if (!$lastDateUpdate) {
        //         $lastDateUpdate = new Date();
        //     }

        //     $opts = array(
        //     'http' => array(
        //         'method' => "GET",
        //         'header' => "X-Requested-With: XMLHttpRequest"
        //     )
        // );
        //     $context = stream_context_create($opts);
        //     $response = null;
        //     $countRequest = 1;
        //     while (true) {
        //         $req = @file_get_contents("https://1xstavka.ru/results/getMain?showAll=true&date={$dateMatch}", false, $context);
        //         if ($req !== false) {
        //             $url = json_decode($req, true);
        //             $response = $url['results'];
        //             break;
        //         } else {
        //             $countRequest++;
        //             if ($countRequest == 20) {
        //                 break;
        //             };
        //             sleep(1);
        //             continue;
        //         }
        //     }
        
        //     if (isset($response)) {
        //         foreach ($response as $sport) {
        //             if ($sport['Name'] == "Настольный теннис") {
        //                 $tennis = $sport;
        //                 break;
        //             }
        //         }

        //         foreach ($tennis['Elems'] as $match) {
        //             foreach ($match['Elems'] as $match) {
        //                 $currentMatch = Match::where('idgame', $match['idgame'])->first();
        //                 $currentChamp = Champ::where('name', $match['champName'])->first();
        //                 if (!$currentChamp) {
        //                     $currentChamp = new Champ();
        //                     $currentChamp['name'] = $match['champName'];
        //                     $currentChamp->save();
        //                 }
        //                 $player1 = Player::where('name', $match['opp1'])->first();
        //                 if (!$player1) {
        //                     $player1 = new Player();
        //                     $player1['name'] = $match['opp1'];
        //                     $player1->save();
        //                 }
        //                 $player2 = Player::where('name', $match['opp2'])->first();
        //                 if (!$player2) {
        //                     $player2 = new Player();
        //                     $player2['name'] = $match['opp2'];
        //                     $player2->save();
        //                 }
        //                 if (!$currentMatch) {
        //                     $object = new Match();
        //                     $object["idgame"] = $match["idgame"];
        //                     $object["sportId"] = $match["sportId"];
        //                     $object["sportName"] = $match["sportName"];
        //                     $object["champId"] = $match["champId"];
        //                     $object["champName"] = $match["champName"];
        //                     $object["nameGame"] = $match["nameGame"];
        //                     $object["gameTyp"] = $match["gameTyp"];
        //                     $object["opp1"] = $player1->id;
        //                     $object["opp2"] = $player2->id;
        //                     $object["ResultPriority"] = $match["ResultPriority"];
        //                     $object["clid_opp1"] = $match["clid_opp1"] ?? null;
        //                     $object["clid_opp2"] = $match["clid_opp2"] ?? null;
        //                     $object["country"] = $match["country"];
        //                     $object["idbetgames_main"] = $match["idbetgames_main"];
        //                     $object["opp1Country"] = $match["opp1Country"] ?? null;
        //                     $object["opp2Country"] = $match["opp2Country"] ?? null;
        //                     $object["dopScore"] = $match["dopScore"] ?? null;
        //                     $object["IdSubGame"] = $match["IdSubGame"];

                      
        //                     $dateResMatch = Carbon::createFromFormat('d.m H:i', $match["date"]);
        //                     $dateMatchMonth = Carbon::parse($dateResMatch)->month;
        //                     $dateMonthSearch = Carbon::parse($dateMatch)->month;
        //                     $year = $dateYear;
        //                     if ($dateMonthSearch < $dateMatchMonth) {
        //                         $year--;
        //                     }

        //                     $object["date"] = Carbon::createFromFormat('Y.d.m H:i', $year . '.' . $match["date"]);
        //                     $object["add_info"] = $match["add_info"];
        //                     $object["scores"] = $match["scores"][0];
        //                     $object->save();
        //                 }
        //                 if (isset($match['sub_games'])) {
        //                     $sub_games = $match['sub_games'];
        //                     foreach ($sub_games as $sub_game) {
        //                         $currentSubMatch = Match::where('idgame', $sub_game["idgame"])->first();
        //                         if (!$currentSubMatch) {
        //                             $dateResMatch = Carbon::createFromFormat('d.m H:i', $match["date"]);
        //                             $dateMatchMonth = Carbon::parse($dateResMatch)->month;
        //                             $dateMonthSearch = Carbon::parse($dateMatch)->month;
        //                             $year = $dateYear;
        //                             if ($dateMonthSearch < $dateMatchMonth) {
        //                                 $year--;
        //                             }
        //                             $sub_object = new Match();
        //                             $sub_object["idgame"] = $sub_game["idgame"];
        //                             $sub_object["sportId"] = $sub_game["sportId"];
        //                             $sub_object["sportName"] = $sub_game["sportName"];
        //                             $sub_object["champId"] = $sub_game["champId"];
        //                             $sub_object["champName"] = $sub_game["champName"];
        //                             $sub_object["nameGame"] = $sub_game["nameGame"];
        //                             $sub_object["gameTyp"] = $match["gameTyp"];
        //                             $sub_object["opp1"] = $player1->id;
        //                             $sub_object["opp2"] = $player2->id;
        //                             $sub_object["ResultPriority"] = $sub_game["ResultPriority"];
        //                             $sub_object["clid_opp1"] = $sub_game["clid_opp1"] ?? null;
        //                             $sub_object["clid_opp2"] = $sub_game["clid_opp2"] ?? null;
        //                             $sub_object["country"] = $sub_game["country"];
        //                             $sub_object["idbetgames_main"] = $match["idgame"];
        //                             $sub_object["opp1Country"] = $sub_game["opp1Country"] ?? null;
        //                             $sub_object["opp2Country"] = $sub_game["opp2Country"] ?? null;
        //                             $sub_object["dopScore"] = $sub_game["dopScore"] ?? null;
        //                             $sub_object["IdSubGame"] = $match["IdSubGame"] ?? null;
        //                             $sub_object["date"] = Carbon::createFromFormat('Y.d.m H:i', $year . '.' . $match["date"]) ?? null;
        //                             $sub_object["add_info"] = $sub_game["games_info"] ? $sub_game["games_info"] : $match["add_info"];
        //                             $sub_object["scores"] = $sub_game["Trslt_result"];
        //                             $sub_object->save();
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //         $lastDateUpdate->date = Carbon::now()->format('Y.d.m H:i');
        //         $lastDateUpdate->save();
        //     }
        // }
        // return response()->json($arrayTimes, 200);
        $name = $request->name;
        $player = $this->player->where('name', 'like', '%' . $name . '%')->get();
        return response()->json($player, 200);
    }
    //Запрос на поиск матчей с другими соперниками и совместные матчи
    public function commonMatch(Request $request)
    {
        $countMatches = $request->countMatches; //Количество матчей 
        $champName = $request->champName;  //Чемпионат
        $coopChamps = $request->coopChamps;  //
        $line = $request->line ?? false; // Флаг на матч из линии
        $array = $this->getMatchesSportsmen($request->player1, $request->player2, $champName, $countMatches, $coopChamps, $line, true);
        return response()->json($array, 200);
    }
    //получение совместных игр
    public function getCooperativeMatches($player1, $player2, $champName, $count, $line)
    {
        $count = $count / 2; //количество матчей

        //Если передано имя игроков, а не объект с базы
        if (is_string($player1)) {
            $player1 = $this->player->where('name', $player1)->first();
        }
        if (is_string($player2)) {
            $player2 = $this->player->where('name', $player2)->first();
        }
        //Если игроков нет - возращаем пустой массив
        if (!isset($player1) || !isset($player2)) {
            return array();
        }
        $game1 = [];
        $game2 = [];
        if ($champName !== null && $champName != 'undefined') {
            if (isset($player1) && isset($player2)) {
                if ($count != null) {
                    if ($line) {
                        if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                            $game1 = $this->match->where('opp1', $player1->id)->where('champName', $champName)->where('opp2', $player2->id)->orderBy('date', 'desc')->take($count)->get();
                            $game2 = $this->match->where('opp1', $player2->id)->where('champName', $champName)->where('opp2', $player1->id)->orderBy('date', 'desc')->take($count)->get();
                        } else {
                            $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
                            $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
                        }
                    } else {
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
                    }
                } else {
                    if ($line) {
                        if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                            $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
                            $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
                        } else {
                            $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
                            $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
                        }
                    } else {
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', $champName)->orderBy('date', 'desc')->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', $champName)->orderBy('date', 'desc')->get();
                    }
                }
            }
        } else {
            if (isset($player1) && (isset($player2))) {
                if ($count != null) {
                    if ($line) {
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
                    } else {
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->orderBy('date', 'desc')->take($count)->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->orderBy('date', 'desc')->take($count)->get();
                    }
                } else {
                    if ($line) {
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->get();
                    } else {
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->orderBy('date', 'desc')->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->orderBy('date', 'desc')->get();
                    }
                }
            }
        }
        $mergeArray = collect($game1)->merge($game2)->toArray();
        usort($mergeArray, function ($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t2 - $t1;
        });
        $win1 = 0;
        $win2 = 0;
        $re = '/^\s*(?<masterBefore>\d+)\:(?<masterAfter>\d+)\s*/m';

        foreach ($game1 as $obj) {
            preg_match_all($re, $obj->scores, $matches, PREG_SET_ORDER, 0);
            $first = intval($matches[0]['masterBefore']);
            $second = intval($matches[0]['masterAfter']);
            if ($obj->opp1 == $player1->id) {
                if ($first > $second) {
                    $win1++;
                } else if ($first < $second) {
                    $win2++;
                }
            } else {
                if ($first > $second) {
                    $win2++;
                } else if ($first < $second) {
                    $win1++;
                }
            }
        }
        foreach ($game2 as $obj) {
            preg_match_all($re, $obj->scores, $matches, PREG_SET_ORDER, 0);
            $first = intval($matches[0]['masterBefore']);
            $second = intval($matches[0]['masterAfter']);
            if ($obj->opp2 == $player2->id) {
                if ($first > $second) {
                    $win1++;
                } else if ($first < $second) {
                    $win2++;
                }
            } else {
                if ($first > $second) {
                    $win2++;
                } else if ($first < $second) {
                    $win1++;
                }
            }
        }
        return array(
            'mergeGames' => $mergeArray,
            'player1' => $player1->name,
            'rating1' => $player1->rating,
            'player2' => $player2->name,
            'rating2' => $player2->rating,
            'win1' => $win1,
            'win2' => $win2
        );
    }
    //получение игр каждого игрока
    public function getMatchesSportsmen($player1, $player2, $champName, $countMatches, $coopChamps, $line, $needCommonMatch = true)
    {
        $player1 = $this->player->where('name', $player1)->first();
        $player2 = $this->player->where('name', $player2)->first();
        $last1 = [];
        $last2 = [];
        $last1 = $this->searchMatchesSportsmen($player1, $champName, $countMatches, $line);
        $last2 = $this->searchMatchesSportsmen($player2, $champName, $countMatches, $line);
        $firstPlayerArray = [];
        $secondPlayerArray = [];
        if (isset($player1)) {
            $firstPlayerArray = array(
                'id' => $player1->id,
                'name' => $player1->name,
                'matches' => $last1,
            );
        }
        if (isset($player2)) {
            $secondPlayerArray = array(
                'id' => $player2->id,
                'name' => $player2->name,
                'matches' => $last2,
            );
        }
        $array = [];
        if ($needCommonMatch) 
        {
            $mergePlayersArray = $this->getCooperativeMatches($player1, $player2, $champName, $countMatches, $line);
            $array = array($firstPlayerArray, $secondPlayerArray, $mergePlayersArray);
        }
        else {
            $array = array($firstPlayerArray, $secondPlayerArray);
        }
        return $array;
    }
    private function searchMatchesSportsmen($player, $champName, $count, $line)
    {
        $matches = [];
        if ($line == 'true') {
            if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                if (isset($player)) {
                    $matches  = $this->match->where('champName', $champName)->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id)->orWhere('opp2', $player->id);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            } else {
                if (isset($player)) {
                    $matches  = $this->match->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id)->orWhere('opp2', $player->id);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            }
        } else {
            if ($champName !== 'null' && $champName !== "undefined") {
                if (isset($player)) {
                    $matches  = $this->match->where('champName', $champName)->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id)->orWhere('opp2', $player->id);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            } else {
                if (isset($player)) {
                    $matches  = $this->match->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id)->orWhere('opp2', $player->id);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            }
        }
        $matches = $this->getRatingPlayers($matches, $player->name);
        return $matches;
    }
    private function getRatingPlayers($matches, $player) {
        $array = [];
        foreach($matches as $match) {
            $nameGameArray = explode('-', $match->nameGame);
            $currentPlayer = null;
            if($player != trim($nameGameArray[0])) {
                $currentPlayer = trim($nameGameArray[0]);
            }
            else if($player != trim($nameGameArray[1])) {
                $currentPlayer = trim($nameGameArray[1]);
            }
            $currentRating = $this->player->where('name', $currentPlayer)->pluck('rating');
            $match->rating = $currentRating[0];
            array_push($array, $match);
        }
        return $array;
    }
    private function getEqualPlayers($arrayFirst, $arraySecond, $champName, $countMatchesRivals, $line)
    {
        $objectRivalsMatch = [];
        $rivals = $this->comparingArraysValues($arrayFirst, $arraySecond);
        foreach ($rivals as $rival) {
            $array = [];
            $firstPlayerRivals = $this->getCooperativeMatches($arrayFirst['name'], $rival, $champName, $countMatchesRivals, $line);
            $secondPlayerRivals = $this->getCooperativeMatches($arraySecond['name'], $rival, $champName, $countMatchesRivals, $line);
            array_push($array, $firstPlayerRivals);
            array_push($array, $secondPlayerRivals);
            array_push($objectRivalsMatch, $array);

        }
        return $objectRivalsMatch;
    }
    private function comparingArraysValues($arrayFirst, $arraySecond)
    {
        $firstPlayer = $arrayFirst['name'];
        $firstPlayersRivals = [];

        foreach ($arrayFirst['matches'] as $match) {
            $arrayNameMatch = explode('-', $match->nameGame);
            $rival = '';
            if (trim($arrayNameMatch[0]) != $firstPlayer) {
                $rival = trim($arrayNameMatch[0]);
            } else if (trim($arrayNameMatch[1]) != $firstPlayer) {
                $rival = trim($arrayNameMatch[1]);
            }
            $existSecondPlayer = $this->searchInArray($arraySecond, $rival);
            if ($existSecondPlayer) array_push($firstPlayersRivals, $rival);
        }
        return array_unique($firstPlayersRivals);
    }

    private function searchInArray($arrayMatches, $string)
    {
        $exist = false;
        $currentPlayer = $arrayMatches['name'];
        foreach ($arrayMatches['matches'] as $match) {
            $arrayNameMatch = explode('-', $match->nameGame);
            if (trim($arrayNameMatch[0]) != $currentPlayer && trim($arrayNameMatch[0]) == $string) {
                $exist = true;
            } else if (trim($arrayNameMatch[1]) != $currentPlayer && trim($arrayNameMatch[1]) == $string) {
                $exist = true;
            }
        }
        return $exist;
    }
    //получение всех чемпионатов
    public function getAllChamps(Request $request)
    {
        $champs = ['BoomCup', 'BoomCup. Женщины', 'Mini Table Tennis', 'Mini Table Tennis. Женщины', 'Вин Кап', 'Вин Кап. Женщины', 'Кубок ТТ', 'Кубок ТТ. Женщины', 'Сетка Кап', 'Сетка Кап. Женщины'];
        $champsDB = $this->champ->all()->pluck('name')->toArray();
        $response = array_unique((array_merge($champs, $champsDB)));
        return $response;
    }
    //получение последней даты обновления
    public function getLastUpdateDate(Request $request)
    {
        $lastDateObject = $this->date->first()->date;
        $last = Carbon::createFromFormat('Y.d.m H:i', $lastDateObject)->addHours(3)->format('Y.d.m H:i');
        return $last;
    }
}