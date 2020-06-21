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
            
            $totalArray = [];
            $forArray = [];
            $individualTotalFirstArray = [];
            $individualTotalSecondArray = [];

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
                        array_push($totalArray, $total['P']);
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
                            if(isset($for['P'])) array_push($forArray, $for['P']);
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
                            if(isset($for['P'])) array_push($forArray, $for['P']);
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
                            array_push($totalArray, $total['P']);
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
                        array_push($individualTotalFirstArray, $info['P'] );
                        $individualTotalFirst = $info['P'] ?? '—';
                        if(!isset($individualTotalFirstMore)) {
                            $individualTotalFirstMore = $info['C'] ?? '—';
                        }
                        else {
                            $individualTotalFirstLess = $info['C'] ?? '—';
                        }
                    }

                    if($info['G'] == 62) {
                        array_push($individualTotalSecondArray, $info['P'] );
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
            
            $normallyMatch['totalArray'] = $totalArray;
            $normallyMatch['forArray'] = $forArray;
            $normallyMatch['individualTotalFirstArray'] =  array_unique($individualTotalFirstArray);
            $normallyMatch['individualTotalSecondArray'] =  array_unique($individualTotalSecondArray);

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
    public function getBetsMatch (Request $request) {
        $totalArray = array_unique(json_decode($request->totalArray), SORT_NUMERIC);
        $response = [
            'totalMore'=> [],
            'totalLess'=> [],
        ];
        $coopMatch = app('App\Http\Controllers\API\MatchController')->getCooperativeMatches($request->player1, $request->player2, $request->champName);//TODO:Сделать отдельный класс для работы с матчами.
        $coopMatches = $coopMatch['mergeGames'];
        $regexTotal = "/[\(\,](?<before>\d+)[\:](?<after>\d+)/m";
        forEach($coopMatches as $match) {
            $total = 0;
            $matches = null;
            preg_match_all($regexTotal, $match['scores'],$matches, PREG_SET_ORDER, 0);
            forEach($matches as $mch) {
                $total += $mch['before'] + $mch['after'];
            }
            $passedTotalMore = $this->checkPassedTotalMore($totalArray, $total);
            $passedTotalLess = $this->checkPassedTotalLess($totalArray, $total);
            array_push($response['totalMore'], $passedTotalMore);
            array_push($response['totalLess'], $passedTotalLess);
        }
        $response['totalMore'] = $this->normallyView($response['totalMore']);
        $response['totalLess'] = $this->normallyView($response['totalLess']);
        return response()->json($response, 200);
    }
    private function checkPassedTotalMore($lineTotals, $total) 
    {
        $response = [];
        forEach($lineTotals as $lineTotal) {
            $array = [
                'value' => $total - $lineTotal,
                'linetotal' => strval($lineTotal)
            ];
            array_push($response, $array);
        }
        return $response;
    }
    private function checkPassedTotalLess($lineTotals, $total) 
    {
        $response = [];
        forEach($lineTotals as $lineTotal) {
            $array = [
                'value' => $lineTotal - $total,
                'linetotal' => strval($lineTotal)
            ];
            array_push($response, $array);
        }
        return $response;
    }
    private function normallyView($array) 
    {
        $countMatches = count($array);
        $normallyArray = [];
        forEach($array as $match) {
            forEach($match as $total) {
                if($total['value'] > 0) {
                    if(!isset($normallyArray[$total['linetotal']])) {
                        $normallyArray[$total['linetotal']] = 0;
                    }
                    else {
                        $normallyArray[$total['linetotal']] += 1;
                    }
                }


            }
        }
        return $normallyArray;
    }
}
