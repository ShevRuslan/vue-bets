<?php

namespace App\Http\Controllers\API;;

use App\Models\Champ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Match;
use App\Models\Player;
use App\Models\Date;

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
    //Поиск спортсмена
    public function getSporstsmen(Request $request)
    {
        //TODO: Проверка на пустоту
        $name = $request->name;
        $player = $this->player->where('name', 'like', '%' . $name . '%')->get();
        return response()->json($player, 200);
    }

    public function commonMatch(Request $request)
    {
        $countMatches = $request->countMatches;
        $champName = $request->champName;
        $coopChamps = $request->coopChamps;
        $line = $request->line ?? false;
        $array = $this->getMatchesSportsmen($request->player1, $request->player2, $champName, $countMatches, $coopChamps, $line);
        return response()->json($array, 200);
    }
    public function getCooperativeMatches($player1, $player2, $champName, $count, $line)
    {
        $count = $count / 2;
        //Если передано имя игроков, а не объект с базы
        if (is_string($player1)) {
            $player1 = $this->player->where('name', $player1)->first();
        }
        if (is_string($player2)) {
            $player2 = $this->player->where('name', $player2)->first();
        }
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
                        $game1 = $this->match->where('opp1', $player1->id)->where('opp2', $player2->id)->where('champName', $champName)->orderBy('date', 'desc')->get();
                        $game2 = $this->match->where('opp1', $player2->id)->where('opp2', $player1->id)->where('champName', $champName)->orderBy('date', 'desc')->get();
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
            'player2' => $player2->name,
            'win1' => $win1,
            'win2' => $win2
        );
    }
    public function getMatchesSportsmen($player1, $player2, $champName, $countMatches, $coopChamps, $line)
    {
        $player1 = $this->player->where('name', $player1)->first();
        $player2 = $this->player->where('name', $player2)->first();
        $last1 = [];
        $last2 = [];
        if ($champName !== 'null' && $champName !== "undefined" && $coopChamps == 'true') {
            if ($line) {
                if (isset($player1)) {
                    $last1  = $this->match->where('champName', $champName)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->where(function ($query) use ($player1) {
                            $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                        })->orderBy('date', 'desc')->take($countMatches)->get();
                }
                if (isset($player2)) {
                    $last2  = $this->match->where('champName', $champName)->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->where(function ($query) use ($player2) {
                            $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                        })->orderBy('date', 'desc')->take($countMatches)->get();
                }
            } else {
                if (isset($player1)) {
                    $last1  = $this->match->where('champName', $champName)->where(function ($query) use ($player1) {
                        $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                    })->orderBy('date', 'desc')->take($countMatches)->get();
                }
                if (isset($player2)) {
                    $last2  = $this->match->where('champName', $champName)->where(function ($query) use ($player2) {
                        $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                    })->orderBy('date', 'desc')->take($countMatches)->get();
                }
            }
        } else {
            if ($line) {
                if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
                    if (isset($player1)) {
                        $last1  = $this->match->where('champName', $champName)->where(function ($query) use ($player1) {
                            $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                        })->orderBy('date', 'desc')->take($countMatches)->get();
                    }
                    if (isset($player2)) {
                        $last2  = $this->match->where('champName', $champName)->where(function ($query) use ($player2) {
                            $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                        })->orderBy('date', 'desc')->take($countMatches)->get();
                    }
                } else {
                    if (isset($player1)) {
                        $last1  = $this->match->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->where(function ($query) use ($player1) {
                                $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                            })->orderBy('date', 'desc')->take($countMatches)->get();
                    }
                    if (isset($player2)) {
                        $last2  = $this->match->where('champName', '!=', 'Mini Table Tennis. Женщины')->where('champName', '!=', 'Mini Table Tennis')->where(function ($query) use ($player2) {
                                $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                            })->orderBy('date', 'desc')->take($countMatches)->get();
                    }
                }
            } else {
                if (isset($player1)) {
                    $last1  = $this->match->where(function ($query) use ($player1) {
                        $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                    })->orderBy('date', 'desc')->take($countMatches)->get();
                }
                if (isset($player2)) {
                    $last2  = $this->match->where(function ($query) use ($player2) {
                        $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                    })->orderBy('date', 'desc')->take($countMatches)->get();
                }
            }
        }
        $firstPlayerArray = [];
        $secondPlayerArray = [];
        $mergePlayersArray = $this->getCooperativeMatches($player1, $player2, $champName, $countMatches, $line);
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
        $array = array($firstPlayerArray, $secondPlayerArray, $mergePlayersArray);
        return $array;
    }
    public function getAllChamps(Request $request)
    {
        $champs = ['BoomCup', 'BoomCup. Женщины', 'Mini Table Tennis', 'Mini Table Tennis. Женщины', 'Вин Кап', 'Вин Кап. Женщины', 'Кубок ТТ', 'Кубок ТТ. Женщины', 'Сетка Кап', 'Сетка Кап. Женщины'];
        $champsDB = $this->champ->all()->pluck('name')->toArray();
        $response = array_unique((array_merge($champs, $champsDB)));
        return $response;
    }
    public function getLastUpdateDate(Request $request)
    {
        $lastDateObject = $this->date->first();
        return $lastDateObject->date;
    }
}
