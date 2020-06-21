<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\API\MatchController;

class LineMatchController extends Controller
{
    public function __construct(MatchController $match){
        $this->match = $match;
    }
    public function line (Request $request)
    {
        // https://1xstavka.ru/LineFeed/GetChampsZip?sport=10&tf=2200000&tz=6&country=1&partner=51&virtualSports=true — получение чемпионатов
        // https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&partner=51&getEmpty=true — получение всех матчей
        //https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=50&tf=2200000&tz=6&antisports=188&mode=4&subGames=240546650&country=1&partner=51&getEmpty=true — subgames
         $opts = array(
                        'http' => array(
                            'method' => "GET",
                            'header' => "X—Requested—With: XMLHttpRequest"
                        )
         );
         $context = stream_context_create($opts);
         $url = json_decode(file_get_contents("https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&partner=51&getEmpty=true", false, $context), true);
         $matches = $url['Value'];
         //return $matches;
         $normallyArrayMatches = ['champs' => []];

         foreach  ($matches as $match) {
            $date = Carbon::parse($match['S'] )->timezone('Europe/Moscow')->format('d.m H:i');
            $normallyMatch = [];
            $currentChamp = $match['L'];

            $player1 = $match['O1'];
            $player2 = $match['O2'];
            
            $normallyMatch['champName'] = $currentChamp;
            $normallyMatch['id'] = $match['I'];
            $normallyMatch['date'] =  $date ?? '—';
            $normallyMatch['player1'] = $player1 ;
            $normallyMatch['player2'] = $player2 ;
            

            if(!isset($normallyMatch['plus'] )) {
                $normallyMatch['plus'] = '+' . $match['EC'] ?? '—';
            }
            $normallyMatch['P1'] = $match['E'][0]['C'] ?? '—';
            $normallyMatch['P2'] = $match['E'][1]['C'] ?? '—';
            
            //17 — total, 2— for, 15 — IT1, 62 — IT2,
            if(isset($match['AE'][0]['G'])) {
                if($match['AE'][0]['G'] == 17) {
                    $totales = $match['AE'][0]['ME']; 

                    foreach($totales as $total) {
                        if(isset($total['CE'])) {
                            if(!isset($normallyMatch['totalMore'])) {
                                $normallyMatch['totalMore'] = $total['C'] ?? '—';
                            }
                            if(isset( $normallyMatch['totalMore'])) {
                                $normallyMatch['totalLess'] = $total['C'] ?? '—';
                            }
                            if(!isset($normallyMatch['total'])) {
                                $normallyMatch['total'] = $total['P'] ?? '—';
                            }
                        }
                    }
                    
                    $fores = $match['AE'][1]['ME'] ?? null; 
                    if(isset($fores)) {
                        foreach($fores as $for) {
                            if(isset($for['CE'])) {
                                if(!isset($normallyMatch['forFirst'] )) {
                                    $normallyMatch['forFirst'] = $for['C'] ?? '—';
                                    if($normallyMatch['forFirst'] != '—') {
                                        if(!isset($normallyMatch['for'])) {
                                            $normallyMatch['for'] = $for['P'];
                                        }
                                        else {
                                            $normallyMatch['for'] = 0;
                                        }
                                    }
                                    else {
                                        $normallyMatch['for'] = '—';
                                    }
                                    $normallyMatch['for'] = $for['P'];
                                }
                                if(isset($normallyMatch['forFirst'])) {
                                    $normallyMatch['forSecond'] = $for['C'] ?? '—';
                                }
                            }
                        
                        }
                    }
                    else {
                        $normallyMatch['for'] = '—';
                        $normallyMatch['forFirst'] = '—';
                        $normallyMatch['forSecond'] = '—';
                    }
                }
                else if($match['AE'][0]['G'] == 2) {
                    $fores = $match['AE'][0]['ME'];
                    if(isset($fores)) {
                        foreach($fores as $for) {
                            if(isset($for['CE'])) {
                                if(!isset($normallyMatch['forFirst'] )) {
                                    $normallyMatch['forFirst'] = $for['C'] ?? '—';
                                    if($normallyMatch['forFirst'] != '—') {
                                        if(!isset($normallyMatch['for'])) {
                                            $normallyMatch['for'] = $for['P'];
                                        }
                                        else {
                                            $normallyMatch['for'] = 0;
                                        }
                                    }
                                    else {
                                        $normallyMatch['for'] = '—';
                                    }
                                    $normallyMatch['for'] = $for['P'];
                                }
                                if(isset($normallyMatch['forFirst'])) {
                                    $normallyMatch['forSecond'] = $for['C'] ?? '—';
                                }
                            }
                        }
                    }
                    else {
                        $normallyMatch['for'] = '—';
                        $normallyMatch['forFirst'] = '—';
                        $normallyMatch['forSecond'] = '—';
                    }

                    $totales = $match['AE'][1]['ME'] ?? null; 
                    if($totales) {
                        foreach($totales as $total) {
                            if(isset($total['CE'])) {
                                if(!isset($normallyMatch['totalMore'])) {
                                    $normallyMatch['totalMore'] = $total['C'] ?? '—';
                                }
                                if(isset( $normallyMatch['totalMore'])) {
                                    $normallyMatch['totalLess'] = $total['C'] ?? '—';
                                }
                                if(!isset($normallyMatch['total'])) {
                                    $normallyMatch['total'] = $total['P'] ?? '—';
                                }
                            }
                        }
                    }
                }
            }
            else {
                $normallyMatch['totalMore'] = '—';
                $normallyMatch['total'] = '—';
                $normallyMatch['totalLess'] =  '—';

                $normallyMatch['forFirst'] = '—';
                $normallyMatch['for'] =  '—';
                $normallyMatch['forSecond'] =  '—';
            }

            $individualTotalFirst = null;
            $individualTotalFirstMore = null;
            $individualTotalFirstLess = null;
            $individualTotalSecond = null;
            $individualTotalSecondMore = null;
            $individualTotalSecondLess = null;
            $drow = null;

            if(count($match['E']) > 0) {
                $informations = $match['E'];
                foreach($informations as $info) {

                    if($info['G'] == 15) {
                        $individualTotalFirst = $info['P'] ?? '—';
                        if(!isset($individualTotalFirstMore)) {
                            $individualTotalFirstMore = $info['C'] ?? '—';
                        }
                        else {
                            $individualTotalFirstLess = $info['C'] ?? '—';
                        }
                    }

                    if($info['G'] == 62) {
                        $individualTotalSecond = $info['P'] ?? '—';
                        if(!isset($individualTotalSecondMore)) {
                            $individualTotalSecondMore = $info['C'] ?? '—';
                        }
                        else {
                            $individualTotalSecondLess = $info['C'] ?? '—';
                        }
                    }
                    if($info['T'] == 2) {
                        $drow = $info['C'];
                    }
                }
            }
            $normallyMatch['drow'] = $drow ?? '—';

            $normallyMatch['individualTotalFirstMore'] = $individualTotalFirstMore ?? '—';
            $normallyMatch['individualTotalFirst'] = $individualTotalFirst ?? '—';
            $normallyMatch['individualTotalFirstLess'] =  $individualTotalFirstLess ?? '—';

            $normallyMatch['individualTotalSecondMore'] = $individualTotalSecondMore ?? '—';
            $normallyMatch['individualTotalSecond'] =  $individualTotalSecond ?? '—';
            $normallyMatch['individualTotalSecondLess'] =  $individualTotalSecondLess ?? '—';
            
            if(!isset($normallyArrayMatches[$currentChamp])) {
                $normallyArrayMatches[$currentChamp] = [];
                array_push($normallyArrayMatches['champs'], $currentChamp);
            }
            array_push($normallyArrayMatches[$currentChamp], $normallyMatch);
         }
         return response()->json($normallyArrayMatches, 200);
    }
    public function getLineChamps(Request $request) 
    {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "X—Requested—With: XMLHttpRequest"
            )
        );
        $context = stream_context_create($opts);
        $response = json_decode(file_get_contents("https://1xstavka.ru/LineFeed/GetChampsZip?sport=10&tf=2200000&tz=6&country=1&partner=51&virtualSports=true ", false, $context), true);
        $champs = $response['Value'];
        $lineChamps = [];
        foreach($champs as $champ) {
            $champArray = [
                'champName' => $champ['L'],
                'img' => $champ['CHIMG'] ?? $champ['CI'],
                'countMatches' => $champ['GC'],
                'id' => $champ['LI']
            ];
            array_push($lineChamps, $champArray);
        }
        return response()->json($lineChamps, 200);
    }
}
