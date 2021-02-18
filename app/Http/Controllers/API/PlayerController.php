<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Match;
use App\Models\UniquePlayer;
use Carbon\Carbon;

class PlayerController extends Controller
{
    protected $player;
    public function __construct(Player $player, Match $match, UniquePlayer $uniqPlayer)
    {
        $this->player = $player;
        $this->match = $match;
        $this->uniqPlayer = $uniqPlayer;
    }
    //обновление рейтинга с setka-cup.com
    // public function getUKPlayers(Request $request)
    // {
    //     $opts = array(
    //         'http' => array(
    //             'method' => "GET",
    //         )
    //     );
    //     $context = stream_context_create($opts);
    //     $name = '(Укр)';
    //     $playersUK = $this->player->where('name', 'like', '%' . $name . '%')->get();
    //     $array = [];

    //     foreach ($playersUK as $playerUK) {
    //         $arrayName = explode(' ', $playerUK->name);
    //         $lastName = $arrayName[1];
    //         $firstName = $arrayName[0];
    //         $lastNameURL = urlencode($lastName);
    //         $response = file_get_contents("https://www.setka-cup.com/api/Players/ru?filter={$lastNameURL}&page=0&count=10&", false, $context);
    //         $json = json_decode($response);
    //         if (!empty($json)) {
    //             foreach ($json as $playerinfo) {
    //                 if ($playerinfo->firstName == $firstName && $playerinfo->lastName == $lastName) {
    //                     $currentPlayer = $this->player->where('name', $playerUK->name)->first();
    //                     if (isset($playerinfo->rating)) {
    //                         $currentPlayer->rating = $playerinfo->rating;
    //                         $currentPlayer->save();
    //                         $arrayInfo = [
    //                             'player' => $playerUK,
    //                             'info' => $playerinfo,
    //                         ];
    //                         array_push($array, $arrayInfo);
    //                     }
    //                 }
    //             }
    //         } else {
    //             continue;
    //         }
    //     }

    //     return response()->json($array, 200);
    // }
    public function readFile(Request $request)
    {
        $array = [];
        $handle = fopen("C:\Users\Руслан\Desktop\игроки609.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $arrayName = explode('"', $line);
                $RUName = trim(preg_replace('/\s\s+/', ' ', $arrayName[1]));
                $UKName = trim(preg_replace('/\s\s+/', ' ', $arrayName[2]));
                if ($UKName != '') {
                    $player = $this->player->where('name', $RUName)->first();
                    $player->ukname = $UKName . ' (Укр)';
                    $player->save();
                    array_push($array, $player);
                }
            }

            fclose($handle);
        } 
        return response()->json($array, 200);
    }
    public function parseSite(Request $request)
    {
        $name = '(Укр)';
        $playersUK = $this->player->where('name', 'like', '%' . $name . '%')->where('ukname', '!=', null)->get();
        $array = [];
        $dateMatch = Carbon::now()->format('Y-m-d');
        $responseMen = file_get_contents("https://ligas.io/api/organizations/uttf/rankings/men/items/{$dateMatch}", false);
        $responseWomen = file_get_contents("https://ligas.io/api/organizations/uttf/rankings/women/items/{$dateMatch}", false);
        $jsonMen = json_decode($responseMen);
        $jsonWomen = json_decode($responseWomen);
        $json = array_merge($jsonMen, $jsonWomen);
        foreach ($playersUK as $player) {
            $player->rating = null;
            $player->save();
            $arrayNameUK = explode(' ', $player->ukname);
            $arrayNameRU = explode(' ', $player->name);
            $normallyName1 = $arrayNameUK[1] . ' ' . $arrayNameUK[0];
            $normallyName2 = $arrayNameRU[1] . ' ' . $arrayNameRU[0];
            $currentSearch = $this->search($json, $normallyName1, $normallyName2);
            if ($currentSearch != null) {
                $player->rating = $currentSearch;
                $player->save();
                array_push($array, [$currentSearch, $player]);
            }
        }
        return response()->json($array, 200);
    }
    private function search($array, $valueUK1, $valueRU)
    {
        $current = [];
        foreach ($array as $element) {
            $elementArray = explode(' ', $element->userName);

            $value1Array = explode(' ', $valueUK1);
            $value3Array = explode(' ', $valueRU);
            if ($element->userName == $valueUK1  || $element->userName == $valueRU) {
                $current = $element->value;
                break;
            }
            if ($elementArray[1] == '') {
                if (($elementArray[0] == $value1Array[1] && $elementArray[2] == $value1Array[0])   || ($elementArray[0] == $value3Array[0] && $elementArray[2] == $value3Array[1])) {
                    $current = $element->value;
                    break;
                }
            } else {
                if (($elementArray[0] == $value1Array[1] && $elementArray[1] == $value1Array[0])  || ($elementArray[0] == $value3Array[0] && $elementArray[1] == $value3Array[1])) {
                    $current = $element->value;
                    break;
                }
            }
        }
        return $current;
    }
    public function matchingPlayers() {
        // $re = '/(?<=[(])[^)]+/';
        // $playersWithNation = $this->player->where('ukname', '!=',  null )->get();
        // foreach($playersWithNation as $player) {
        //     $player1 = $this->uniqPlayer->where('name', $player['name'])->first();
        //     if ($player1) {
        //         $player1['ukname'] = $player['ukname'];
        //         $player1['rating'] = $player['rating'];
        //         $player1->save();
        //     }
        //     else {
        //         echo $player['name'] . "<br>";
        //     }
        // }
        //$playersWithoutNation = $this->player->where('name', 'not regexp',  '(?<=[(])[^)]+' )->pluck('name', 'id');
        // $uniqueMatchesById = $this->match->where("clid_opp2", null)->get();
        // //$uniqueMatchesById = $this->match->where("clid_opp1", null)->pluck('opp1', 'namegame');
        // foreach($uniqueMatchesById as $match) {
        //     $names = explode("-", $match['nameGame']);
        //     if(count($names) > 1) {
        //         $player = trim($names[1]);
        //         $newPlayer = $this->uniqPlayer->where('name', $player)->first();
        //         if(!$newPlayer) {
        //             $newPlayer = new UniquePlayer();
        //             $newPlayer['name'] = $player;
        //             $newPlayer['clid_opp'] = null;
        //             $newPlayer['id_player'] = $match['opp2'];
        //             $newPlayer->save();
        //             echo $player . "<br>";
        //         }
        //         else {
        //             $newPlayer['id_player'] = $match['opp2'];
        //             $newPlayer->save();
        //             echo $player . "<br>";
        //         }
        //     }
        // }
        // $player1 = $this->uniqPlayer('clid_opp', $match['opp1'])->first();
        // if (!$player1) {
        //     $player1 = new Player();
        //     $player1['name'] = $match['opp1'];
        //     $player1->save();
        // }
        //return response()->json($playersWithNation, 200);
    }
}
