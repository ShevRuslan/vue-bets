<?php

namespace App\Http\Controllers\API;

use App\Models\Champ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Match;
use App\Models\Player;
use App\Models\Date;
use App\Models\UniquePlayer;
use Carbon\Carbon;

class MatchController extends Controller
{
    protected $rep;
    protected $match;
    protected $date;
    protected $player;
    protected $champ;
    public function __construct(Match $match, Player $player, Date $date, Champ $champ, UniquePlayer $uniqPlayer)
    {
        $this->player = $player;
        $this->match = $match;
        $this->date = $date;
        $this->champ = $champ;
        $this->uniqPlayer = $uniqPlayer;
    }
    //Получение общих соперников и матчей с ними
    public function getCommonRivals(Request $request)
    {
        $countMatchesRivals = $request->countMatches; //Количество матчей для общих соперников
        $champName = $request->champName;  //Чемпионат
        $line = $request->line ?? false; // Флаг на матч из линии
        $player1 = $request->player1;
        $player2 = $request->player2;
        $playersMatches = $this->getMatchesSportsmen($player1, $player2, $champName, null, null, $line, false);
        $commonRivalsMatches = $this->getEqualPlayers($playersMatches[0], $playersMatches[1], $champName, $countMatchesRivals, $line);
        return response()->json($commonRivalsMatches, 200);
    }
    //Поиск спортсмена
    public function getSporstsmen(Request $request)
    {
        $name = $request->name;
        $player = $this->uniqPlayer->where('name', 'like', '%' . $name . '%')->get();
        return response()->json($player, 200);
    }
    //Запрос на поиск матчей с другими соперниками и совместные матчи
    public function commonMatch(Request $request)
    {
        $countMatches = $request->countMatches; //Количество матчей 
        $champName = $request->champName;  //Чемпионат
        $coopChamps = $request->coopChamps;  //
        $line = $request->line ?? false; // Флаг на матч из линии
        $player1 = $request->player1;
        $player2 = $request->player2;
        $array = $this->getMatchesSportsmen($player1, $player2, $champName, $countMatches, $coopChamps, $line, true);
        return response()->json($array, 200);
    }
    //получение совместных игр
    public function getCooperativeMatches($player1, $player2, $champName, $count, $line)
    {
        $count = $count / 2; //количество матчей

        //Если передано имя игроков, а не объект с базы
        if (is_string($player1)) {
            $player1 = $this->uniqPlayer->where('name', $player1)->first();
        }
        if (is_string($player2)) {
            $player2 = $this->uniqPlayer->where('name', $player2)->first();
        }
        //Если игроков нет - возращаем пустой массив
        if (!isset($player1) || !isset($player2)) {
            return array();
        }
        $mergeArray = [];
        if ($champName !== null && $champName != 'undefined') {
            if (isset($player1) && isset($player2)) {
                if ($count != null) {
                    if ($line == "true") {
                        if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                            $mergeArray = $this->searchCooperativeMatches($player1, $player2, $champName, $count);
                        } else {
                            $mergeArray = $this->searchCooperativeMatchesWithoutChamps($player1, $player2, $champName, $count);
                        }
                    } else {
                        $mergeArray = $this->searchCooperativeMatches($player1, $player2, $champName, $count);
                    }
                } else {
                    if ($line == "true") {
                        if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                            $mergeArray = $this->searchCooperativeMatches($player1, $player2, $champName, $count);
                        } else {
                            $mergeArray = $this->searchCooperativeMatchesWithoutChamps($player1, $player2, $champName, $count);
                        }
                    } else {
                        $mergeArray = $this->searchCooperativeMatches($player1, $player2, $champName, $count);
                    }
                }
            }
        } else {
            if (isset($player1) && (isset($player2))) {
                if ($count != null) {
                    if ($line == "true") {
                        $mergeArray = $this->searchCooperativeMatchesWithoutChamps($player1, $player2, $champName, $count);
                    } else {
                        $mergeArray = $this->searchCooperativeMatches($player1, $player2, null, $count);
                    }
                } else {
                    if ($line = "true") {
                        $mergeArray = $this->searchCooperativeMatchesWithoutChamps($player1, $player2, $champName, null);
                    } else {
                        $mergeArray = $this->searchCooperativeMatches($player1, $player2, null, $count);
                    }
                }
            }
        }
        usort($mergeArray, function ($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t2 - $t1;
        });
        $win1 = 0;
        $win2 = 0;
        $re = '/^\s*(?<masterBefore>\d+)\:(?<masterAfter>\d+)\s*/m';
        foreach ($mergeArray as $match) {
            $obj = (object) $match;
            preg_match_all($re, $obj->scores, $matches, PREG_SET_ORDER, 0);
            $first = intval($matches[0]['masterBefore']);
            $second = intval($matches[0]['masterAfter']);
            if ($obj->opp1 == $player1->id_player || $obj->clid_opp1 == $player1->clid_opp) {
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
    private function unique_multidim_array($array, $key) 
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    } 
    private function searchCooperativeMatchesWithoutChamps($player1, $player2, $champName, $count) 
    {
        $array = [];
        if($count != null) {
            $game1 = $this->match->where('opp1', $player1->id_player)->where('opp2', $player2->id_player)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
            $game2 = $this->match->where('opp1', $player2->id_player)->where('opp2', $player1->id_player)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
            $game3 = $this->match->where('clid_opp1', $player1->clid_opp)->where('clid_opp2', $player2->clid_opp)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
            $game4 = $this->match->where('clid_opp1', $player2->clid_opp)->where('clid_opp2', $player1->clid_opp)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->take($count)->get();
        }
        else {
            $game1 = $this->match->where('opp1', $player1->id_player)->where('opp2', $player2->id_player)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->get();
            $game2 = $this->match->where('opp1', $player2->id_player)->where('opp2', $player1->id_player)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->get();
            $game3 = $this->match->where('clid_opp1', $player1->clid_opp)->where('clid_opp2', $player2->clid_opp)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->get();
            $game4 = $this->match->where('clid_opp1', $player2->clid_opp)->where('clid_opp2', $player1->clid_opp)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->orderBy('date', 'desc')->get();
        }

        
        $mergeArray = collect($game1)->merge($game2)->merge($game3)->merge($game4)->toArray();
        $uniq = $this->unique_multidim_array($mergeArray, "idbetgames_main");
        return $uniq;
    }
    private function searchCooperativeMatches($player1, $player2, $champName, $count) 
    {
        $array = [];
        if($champName != null) {
            $game1 = $this->match->where('opp1', $player1->id_player)->where('opp2', $player2->id_player)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
            $game2 = $this->match->where('opp1', $player2->id_player)->where('opp2', $player1->id_player)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
            $game3 = $this->match->where('clid_opp1', $player1->clid_opp)->where('clid_opp2', $player2->clid_opp)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
            $game4 = $this->match->where('clid_opp1', $player2->clid_opp)->where('clid_opp2', $player1->clid_opp)->where('champName', $champName)->orderBy('date', 'desc')->take($count)->get();
        }
        else {
            $game1 = $this->match->where('opp1', $player1->id_player)->where('opp2', $player2->id_player)->orderBy('date', 'desc')->take($count)->get();
            $game2 = $this->match->where('opp1', $player2->id_player)->where('opp2', $player1->id_player)->orderBy('date', 'desc')->take($count)->get();
            $game3 = $this->match->where('clid_opp1', $player1->clid_opp)->where('clid_opp2', $player2->clid_opp)->orderBy('date', 'desc')->take($count)->get();
            $game4 = $this->match->where('clid_opp1', $player2->clid_opp)->where('clid_opp2', $player1->clid_opp)->orderBy('date', 'desc')->take($count)->get();
        }
        $mergeArray = collect($game1)->merge($game2)->merge($game3)->merge($game4)->toArray();
        $uniq = $this->unique_multidim_array($mergeArray, "idbetgames_main");
        return $uniq;
    }
    //получение игр каждого игрока
    public function getMatchesSportsmen($player1, $player2, $champName, $countMatches, $coopChamps, $line, $needCommonMatch = true)
    {
        $player1 = $this->uniqPlayer->where('name', $player1)->first();
        $player2 = $this->uniqPlayer->where('name', $player2)->first();
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
        if ($line == "true") {
            if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                if (isset($player)) {
                    $matches  = $this->match->where('champName', $champName)->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id_player)->orWhere('opp2', $player->id_player);
                    })->orWhere(function ($query) use ($player) {
                        $query->where('clid_opp1', $player->clid_opp)->orWhere('clid_opp2', $player->clid_opp);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            } else {
                if (isset($player)) {
                    $matches  = $this->match->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id_player)->orWhere('opp2', $player->id_player);
                    })->orWhere(function ($query) use ($player) {
                        $query->where('clid_opp1', $player->clid_opp)->orWhere('clid_opp2', $player->clid_opp);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            }
        } else {
            if ($champName !== 'null' && $champName !== "undefined") {
                if (isset($player)) {
                    $matches1 = $this->match->where('champName', $champName)->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id_player)->orWhere('opp2', $player->id_player);
                    })->orderBy('date', 'desc')->take($count)->get()->toArray();
                    $matches2 = $this->match->where('champName', $champName)->where(function ($query) use ($player) {
                        $query->where('clid_opp1', $player->clid_opp)->orWhere('clid_opp2', $player->clid_opp);
                    })->orderBy('date', 'desc')->take($count)->get()->toArray();
                    
                    $matches = (object) array_merge((array) $matches1, (array) $matches2);
                }
            } else {
                if (isset($player)) {
                    $matches  = $this->match->where(function ($query) use ($player) {
                        $query->where('opp1', $player->id_player)->orWhere('opp2', $player->id_player);
                    })->orWhere(function ($query) use ($player) {
                        $query->where('clid_opp1', $player->clid_opp)->orWhere('clid_opp2', $player->clid_opp);
                    })->orderBy('date', 'desc')->take($count)->get();
                }
            }
        }
        $matches = $this->getRatingPlayers($matches, $player);
        return $matches;
    }
    private function getRatingPlayers($matches, $player) {
        $clid_opp = $player->clid_opp;
        $id_player = $player->id_player;
        $array = [];
        foreach($matches as $match) {
            $matchObject = (object) $match;
            $currentPlayer = null;
            $currentRating = null;
            if($clid_opp != null) {
                $currentPlayer = $clid_opp == $matchObject->clid_opp1 ? $matchObject->clid_opp2 : $matchObject->clid_opp1;
                $currentRating = $this->uniqPlayer->where('clid_opp', $currentPlayer)->pluck('rating'); 
            }
            else if ($id_player != null) {
                $currentPlayer = $id_player == $matchObject->opp1 ? $matchObject->opp2 : $matchObject->opp1;
                $currentRating = $this->uniqPlayer->where('id_player', $currentPlayer)->pluck('rating'); 
            }
            $matchObject->rating = $currentRating[0];
            array_push($array, $matchObject);
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
