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
    public function __construct(Match $match, Player $player, Date $date, Champ $champ){
        $this->player = $player;
        $this->match = $match;
        $this->date = $date;
        $this->champ = $champ;
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
        $champName = $request->champName;
        $array = $this->getMatchesSportsmen($request->player1, $request->player2, $champName, $countMatches );
        return response()->json($array, 200);
    }
    public function getMatchesSportsmen($player1, $player2, $champName, $countMatches = 10) 
    {
        $player1 = $this->player->where('name', $player1)->first();

        $player2 = $this->player->where('name', $player2)->first();
        
        $game1 = [];
        $game2 = [];
        $last1 = [];
        $last2 = [];

        if($champName !== 'null') {
            if(isset($player1) && isset($player2)) {
                $game1 = $this->match->where('opp1', $player1->id)->where('opp2',$player2->id)->where('champName', $champName)->orderBy('date', 'desc')->get();
                $game2 = $this->match->where('opp1',$player2->id)->where('opp2',$player1->id)->where('champName', $champName)->orderBy('date', 'desc')->get();
            }
            if(isset($player1)) {
                $last1  = $this->match->where('champName', $champName)->where(function($query) use($player1) {
                    $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                })->orderBy('date', 'desc')->take($countMatches)->get();
            }
            if(isset($player2)) {
                $last2  = $this->match->where('champName', $champName)->where(function($query) use($player2) {
                    $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                })->orderBy('date', 'desc')->take($countMatches)->get();
            }
            
        }
        else {
            if(isset($player1) && (isset($player2))) {
                $game1 = $this->match->where('opp1', $player1->id)->where('opp2',$player2->id)->orderBy('date', 'desc')->get();

                $game2 = $this->match->where('opp1',$player2->id)->where('opp2',$player1->id)->orderBy('date', 'desc')->get();
            }

            if(isset($player1)) {
                $last1  = $this->match->where(function($query) use($player1) {
                    $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
                })->orderBy('date', 'desc')->take($countMatches)->get();
            }
            if(isset($player2)) {
                $last2  = $this->match->where(function($query) use($player2) {
                    $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
                })->orderBy('date', 'desc')->take($countMatches)->get();
            }
            
        }

        $mergeArray = collect($game1)->merge($game2)->toArray();
        usort($mergeArray, function($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t2 - $t1;
        });
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
        $firstPlayerArray = [];
        $secondPlayerArray = [];
        $mergePlayersArray = [];
        if(isset($player1)) {
            $firstPlayerArray = array(
                'id' => $player1->id,
                'name' => $player1->name,
                'matches' => $last1, 
            );
        }
        if(isset($player2)) {
            $secondPlayerArray = array(
                'id' => $player2->id,
                'name' => $player2->name,
                'matches' => $last2,
            );
        }
        if(isset($player1) && isset($player2)) {
            $mergePlayersArray =  array(
                'mergeGames'=> $mergeArray, 
                'player1'=> $player1->name,
                'player2'=>$player2->name,
                'win1' => $win1, 
                'win2' => $win2
            );
        }
        $array = array($firstPlayerArray, $secondPlayerArray, $mergePlayersArray);

        return $array;
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
