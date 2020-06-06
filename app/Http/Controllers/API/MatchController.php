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

        $player1 = $this->player->where('name', $request->player1)->first();

        $player2 = $this->player->where('name', $request->player2)->first();
        

        if($champName !== 'null') {
            $game1 = $this->match->where('opp1', $player1->id)->where('opp2',$player2->id)->where('champName',$request->champName)->orderBy('date', 'desc')->get();

            $game2 = $this->match->where('opp1',$player2->id)->where('opp2',$player1->id)->where('champName',$request->champName)->orderBy('date', 'desc')->get();
    
            $last1  = $this->match->where('champName', $request->champName)->where(function($query) use($player1) {
                $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
            })->orderBy('date', 'desc')->take($countMatches)->get();
            
            $last2  = $this->match->where('champName', $request->champName)->where(function($query) use($player2) {
                $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
            })->orderBy('date', 'desc')->take($countMatches)->get();
            
        }
        else {
            $game1 = $this->match->where('opp1', $player1->id)->where('opp2',$player2->id)->orderBy('date', 'desc')->get();

            $game2 = $this->match->where('opp1',$player2->id)->where('opp2',$player1->id)->orderBy('date', 'desc')->get();
    
            $last1  = $this->match->where(function($query) use($player1) {
                $query->where('opp1', $player1->id)->orWhere('opp2', $player1->id);
            })->orderBy('date', 'desc')->take($countMatches)->get();
            
            $last2  = $this->match->where(function($query) use($player2) {
                $query->where('opp1', $player2->id)->orWhere('opp2', $player2->id);
            })->orderBy('date', 'desc')->take($countMatches)->get();
            
        }

        $mergeArray = collect($game1)->merge($game2);

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
