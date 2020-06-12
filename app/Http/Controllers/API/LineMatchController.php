<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
class LineMatchController extends Controller
{
    public function line (Request $request)
    {
        // https://1xstavka.ru/LineFeed/GetChampsZip?sport=10&tf=2200000&tz=6&country=1&partner=51&virtualSports=true - получение чемпионатов
        // https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&partner=51&getEmpty=true - получение всех матчей
        //https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=50&tf=2200000&tz=6&antisports=188&mode=4&subGames=240546650&country=1&partner=51&getEmpty=true - subgames
         $opts = array(
                        'http' => array(
                            'method' => "GET",
                            'header' => "X-Requested-With: XMLHttpRequest"
                        )
         );
         $context = stream_context_create($opts);
         $url = json_decode(file_get_contents("https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&partner=51&getEmpty=true", false, $context), true);
         $matches = $url['Value'];
         //return $matches;
         $normallyArrayMatches = [];

         foreach  ($matches as $match) {
            $date = Carbon::parse($match['S'] )->timezone('Europe/Moscow')->format('d.m H:i');

            $normallyMatch = [];

            $normallyMatch['date'] =  $date ?? '-';
            $normallyMatch['nameMatch'] = $match['O1'] . ' - ' . $match['O2'];

            $normallyMatch['plus'] = '+' . $match['EC'] ?? '-';

            $normallyMatch['P1'] = $match['E'][0]['C'] ?? '-';
            $normallyMatch['P2'] = $match['E'][1]['C'] ?? '-';
            
            //17 - total, 2- for, 15 - IT1, 62 - IT2,
            if(isset($match['AE'][0]['G'])) {
                //total
                if($match['AE'][0]['G'] == 17) {
                    $totales = $match['AE'][0]['ME']; 
                     //TODO: Цикл и делать массив
                    $normallyMatch['totalMore'] = $totales[0]['C'] ?? '-';
                    $normallyMatch['total'] = $totales[0]['P'] ?? '-';
                    $normallyMatch['totalLess'] = $totales[1]['C'] ?? '-';
    
                    $fores = $match['AE'][1]['ME'] ?? null;

                    $normallyMatch['forFirst'] = $fores[0]['C'] ?? '-';
                    if($normallyMatch['forFirst'] != '-') {
                        if(isset($fores[0]['P'])) {
                            $normallyMatch['for'] = $fores[0]['P'];
                        }
                        else {
                            $normallyMatch['for'] = 0;
                        }
                    }
                    else {
                        $normallyMatch['for'] = '-';
                    }
                    $normallyMatch['forSecond'] = $fores[1]['C'] ?? '-';
                }
                //for
                else if($match['AE'][0]['G'] == 2) {
                    //TODO: Цикл и делать массив
                    $fores = $match['AE'][0]['ME'];

                    $normallyMatch['forFirst'] = $fores[0]['C'] ?? '-';
                    if($normallyMatch['forFirst'] != '-') {
                        if(isset($fores[0]['P'])) {
                            $normallyMatch['for'] = $fores[0]['P'];
                        }
                        else {
                            $normallyMatch['for'] = 0;
                        }
                    }
                    else {
                        $normallyMatch['for'] = '-';
                    }
                    $normallyMatch['forSecond'] = $fores[1]['C'] ?? '-';

                    $totales = $match['AE'][1]['ME'] ?? null; 

                    $normallyMatch['totalMore'] = $totales[0]['C'] ?? '-';
                    $normallyMatch['total'] = $totales[0]['P'] ?? '-';
                    $normallyMatch['totalLess'] = $totales[1]['C'] ?? '-';
                }
            }
            else {
                $normallyMatch['totalMore'] = '-';
                $normallyMatch['total'] = '-';
                $normallyMatch['totalLess'] =  '-';

                $normallyMatch['forFirst'] = '-';
                $normallyMatch['for'] =  '-';
                $normallyMatch['forSecond'] =  '-';
            }

            if(count($match['E']) > 0) {
                $infs = $match['E'];
                foreach($infs as $info) {
                    if($info['G'] == 15) {
                        $normallyMatch['individualTotalFirst'] = $info['P'] ?? '-';
                        if(!isset($normallyMatch['individualTotalFirstMore'])) {
                            $normallyMatch['individualTotalFirstMore'] = $info['C'] ?? '-';
                        }
                        else {
                            $normallyMatch['individualTotalFirstLess'] = $info['C'] ?? '-';
                        }
                    }
                    if($info['G'] == 62) {
                        $normallyMatch['individualTotalSecond'] = $info['P'] ?? '-';
                        if(!isset($normallyMatch['individualTotalSecondMore'])) {
                            $normallyMatch['individualTotalSecondMore'] = $info['C'] ?? '-';
                        }
                        else {
                            $normallyMatch['individualTotalSecondLess'] = $info['C'] ?? '-';
                        }
                    }
                }
            }
                $normallyMatch['individualTotalFirstMore'] = $normallyMatch['individualTotalFirstMore'] ?? '-';
                $normallyMatch['individualTotalFirst'] = $normallyMatch['individualTotalFirst'] ?? '-';
                $normallyMatch['individualTotalFirstLess'] =  $normallyMatch['individualTotalFirstLess'] ?? '-';
    
                $normallyMatch['individualTotalSecondMore'] = $normallyMatch['individualTotalSecondMore'] ?? '-';
                $normallyMatch['individualTotalSecond'] =  $normallyMatch['individualTotalSecond'] ?? '-';
                $normallyMatch['individualTotalSecondLess'] =  $normallyMatch['individualTotalSecondLess'] ?? '-';

            array_push($normallyArrayMatches, $normallyMatch);
         }
         return $normallyArrayMatches;
    }
}
