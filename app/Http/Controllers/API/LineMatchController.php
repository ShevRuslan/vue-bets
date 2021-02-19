<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Player;
use App\Http\Controllers\API\MatchController;

class LineMatchController extends Controller
{
    public function __construct(MatchController $match, Player $player)
    {
        $this->match = $match;
        $this->player = $player;
    }
    //получение матчей с линии и формирование данных в нормальный вид из непонятонго жсона
    public function line(Request $request)
    {
        // https://1xstavka.ru/LineFeed/GetChampsZip?sport=10&tf=2200000&tz=6&country=1&partner=51&virtualSports=true — получение чемпионатов
        // https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&partner=51&getEmpty=true — получение всех матчей
        //https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=50&tf=2200000&tz=6&antisports=188&mode=4&subGames=240546650&country=1&partner=51&getEmpty=true — subgames
        //"http://1xbet.com/LineFeed/GetChampsZip?sport=10&tf=2200000&tz=6&virtualSports=true " - 1xbet champs
        //https://1xbet.com/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&getEmpty=true - line 1xbet
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "X—Requested—With: XMLHttpRequest"
            )
        );
        $context = stream_context_create($opts);
        $url = json_decode(file_get_contents("https://1xstavka.ru/LineFeed/Get1x2_VZip?sports=10&count=5000&tf=2200000&tz=6&antisports=188&mode=4&country=1&getEmpty=true", false, $context), true);
        $matches = $url['Value'];
        $normallyArrayMatches = ['champs' => []];

        foreach ($matches as $match) {
            $date = Carbon::parse($match['S'])->timezone('Europe/Moscow')->format('d.m H:i');
            $normallyMatch = [];
            $currentChamp = $match['L'];

            $player1 = $match['O1'];
            $player2 = $match['O2'];

            $normallyMatch['champName'] = $currentChamp;
            $normallyMatch['id'] = $match['I'];
            $normallyMatch['date'] =  $date ?? '—';
            $normallyMatch['player1'] = $player1;
            $normallyMatch['rating1'] = $this->player->where('name', $player1)->pluck('rating')[0] ?? null;
            $normallyMatch['player2'] = $player2;
            $normallyMatch['rating2'] = $this->player->where('name', $player2)->pluck('rating')[0] ?? null;

            $totalArray = [];
            $forArray = [
                'firstPlayer' => [],
                'secondPlayer' => [],
            ];
            $individualTotalFirstArray = [];
            $individualTotalSecondArray = [];

            if (!isset($normallyMatch['plus'])) {
                if (isset($match['EC'])) $normallyMatch['plus'] = '+' . $match['EC'] ?? '—';
            }
            $normallyMatch['P1'] = $match['E'][0]['C'] ?? '—';
            $normallyMatch['P2'] = $match['E'][1]['C'] ?? '—';

            //17 — total, 2— for, 15 — IT1, 62 — IT2,
            if (isset($match['AE'][0]['G'])) {
                if ($match['AE'][0]['G'] == 17) {
                    $totales = $match['AE'][0]['ME'];

                    foreach ($totales as $total) {
                        array_push($totalArray, $total['P']);
                        if (isset($total['CE'])) {
                            if (!isset($normallyMatch['totalMore'])) {
                                $normallyMatch['totalMore'] = $total['C'] ?? '—';
                            }
                            if (isset($normallyMatch['totalMore'])) {
                                $normallyMatch['totalLess'] = $total['C'] ?? '—';
                            }
                            if (!isset($normallyMatch['total'])) {
                                $normallyMatch['total'] = $total['P'] ?? '—';
                            }
                        }
                    }

                    $fores = $match['AE'][1]['ME'] ?? null;
                    if (isset($fores)) {
                        foreach ($fores as $for) {
                            if ($for['T'] == 7) {
                                if (isset($for['C']) && !isset($for['P'])) {
                                    array_push($forArray['firstPlayer'], 0);
                                } else {
                                    array_push($forArray['firstPlayer'], $for['P']);
                                }
                            } else if ($for['T'] == 8) {
                                if (!isset($for['P'])) {
                                    array_push($forArray['secondPlayer'], '0');
                                } else {
                                    array_push($forArray['secondPlayer'], $for['P']);
                                }
                            }
                            if (isset($for['CE'])) {
                                if (!isset($normallyMatch['forFirst'])) {
                                    $normallyMatch['forFirst'] = $for['C'] ?? '—';
                                    if ($normallyMatch['forFirst'] != '—') {
                                        if (!isset($normallyMatch['for'])) {
                                            $normallyMatch['for'] = $for['P'];
                                        } else {
                                            $normallyMatch['for'] = 0;
                                        }
                                    } else {
                                        $normallyMatch['for'] = '—';
                                    }
                                    $normallyMatch['for'] = $for['P'];
                                }
                                if (isset($normallyMatch['forFirst'])) {
                                    $normallyMatch['forSecond'] = $for['C'] ?? '—';
                                }
                            }
                        }
                    } else {
                        $normallyMatch['for'] = '—';
                        $normallyMatch['forFirst'] = '—';
                        $normallyMatch['forSecond'] = '—';
                    }
                } else if ($match['AE'][0]['G'] == 2) {
                    $fores = $match['AE'][0]['ME'];
                    if (isset($fores)) {
                        foreach ($fores as $for) {
                            if ($for['T'] == 7) {
                                if (isset($for['C']) && !isset($for['P'])) {
                                    array_push($forArray['firstPlayer'], 0);
                                } else {
                                    array_push($forArray['firstPlayer'], $for['P']);
                                }
                            } else if ($for['T'] == 8) {
                                if (!isset($for['P'])) {
                                    array_push($forArray['secondPlayer'], '0');
                                } else {
                                    array_push($forArray['secondPlayer'], $for['P']);
                                }
                            }
                            if (isset($for['CE'])) {
                                if (!isset($normallyMatch['forFirst'])) {
                                    $normallyMatch['forFirst'] = $for['C'] ?? '—';
                                    if ($normallyMatch['forFirst'] != '—') {
                                        if (!isset($normallyMatch['for'])) {
                                            $normallyMatch['for'] = $for['P'];
                                        } else {
                                            $normallyMatch['for'] = 0;
                                        }
                                    } else {
                                        $normallyMatch['for'] = '—';
                                    }
                                    $normallyMatch['for'] = $for['P'];
                                }
                                if (isset($normallyMatch['forFirst'])) {
                                    $normallyMatch['forSecond'] = $for['C'] ?? '—';
                                }
                            }
                        }
                    } else {
                        $normallyMatch['for'] = '—';
                        $normallyMatch['forFirst'] = '—';
                        $normallyMatch['forSecond'] = '—';
                    }

                    $totales = $match['AE'][1]['ME'] ?? null;
                    if ($totales) {
                        foreach ($totales as $total) {
                            array_push($totalArray, $total['P']);
                            if (isset($total['CE'])) {
                                if (!isset($normallyMatch['totalMore'])) {
                                    $normallyMatch['totalMore'] = $total['C'] ?? '—';
                                }
                                if (isset($normallyMatch['totalMore'])) {
                                    $normallyMatch['totalLess'] = $total['C'] ?? '—';
                                }
                                if (!isset($normallyMatch['total'])) {
                                    $normallyMatch['total'] = $total['P'] ?? '—';
                                }
                            }
                        }
                    }
                }
            } else {
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

            if (count($match['E']) > 0) {
                $informations = $match['E'];
                foreach ($informations as $info) {

                    if ($info['G'] == 15) {
                        array_push($individualTotalFirstArray, $info['P']);
                        $individualTotalFirst = $info['P'] ?? '—';
                        if (!isset($individualTotalFirstMore)) {
                            $individualTotalFirstMore = $info['C'] ?? '—';
                        } else {
                            $individualTotalFirstLess = $info['C'] ?? '—';
                        }
                    }

                    if ($info['G'] == 62) {
                        array_push($individualTotalSecondArray, $info['P']);
                        $individualTotalSecond = $info['P'] ?? '—';
                        if (!isset($individualTotalSecondMore)) {
                            $individualTotalSecondMore = $info['C'] ?? '—';
                        } else {
                            $individualTotalSecondLess = $info['C'] ?? '—';
                        }
                    }
                    if ($info['T'] == 2) {
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

            if (!isset($normallyArrayMatches[$currentChamp])) {
                $normallyArrayMatches[$currentChamp] = [];
                array_push($normallyArrayMatches['champs'], $currentChamp);
            }
            array_push($normallyArrayMatches[$currentChamp], $normallyMatch);
        }
        return response()->json($normallyArrayMatches, 200);
    }
    //получение всех чемпионатов с линии
    public function getLineChamps(Request $request)
    {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "X—Requested—With: XMLHttpRequest"
            )
        );
        $context = stream_context_create($opts);
        $response = json_decode(file_get_contents("http://1xstavka.ru/LineFeed/GetChampsZip?sport=10&tf=2200000&tz=6&virtualSports=true  ", false, $context), true);
        $champs = $response['Value'];
        $lineChamps = [];
        foreach ($champs as $champ) {
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
    //получение и формирование таблицы ставок на основе совместных матчей
    public function getBetsMatch(Request $request)
    {
        $player = $request->player1;
        $totalArray = array_unique(json_decode($request->totalArray), SORT_NUMERIC);
        $forArray = json_decode($request->forArray);
        $individualTotalFirstArray = json_decode($request->individualTotalFirstArray);
        $individualTotalSecondArray = json_decode($request->individualTotalSecondArray);
        $champName = $request->champName;
        if ($champName == 'Mini Table Tennis. Женщины' || $champName == 'Mini Table Tennis') {
            $coopMatch = app('App\Http\Controllers\API\MatchController')->getCooperativeMatches($request->player1, $request->player2, $champName, $request->countMatches, true);
        } else {
            $coopMatch = app('App\Http\Controllers\API\MatchController')->getCooperativeMatches($request->player1, $request->player2, null, $request->countMatches, true);
        }
        if (isset($coopMatch['mergeGames'])) {
            $coopMatches = $coopMatch['mergeGames'];
            $response = [
                'total' => [],
                'forFirst' => [],
                'forSecond' => [],
                'individualTotalFirst' => [],
                'individualTotalSecond' => [],
                'win1' => $coopMatch['win1'],
                'win2' => $coopMatch['win2'],
                'countGames' =>  $coopMatch['win1'] +  $coopMatch['win2']
            ];
            $totalMore = [];
            $totalLess = [];
            $individualTotalFirstMore = [];
            $individualTotalFirstLess = [];
            $individualTotalSecondMore = [];
            $individualTotalSecondLess = [];
            $forFirstArray = [];
            $forSecondArray = [];

            $regexTotal = "/[\(\,](?<before>\d+)[\:](?<after>\d+)/m";

            foreach ($coopMatches as $match) {
                $reverse = false;

                $arrayNames = explode('-', $match['nameGame']);
                $first = trim($arrayNames[0]);
                if ($first !== $player) {
                    $reverse = true;
                } else {
                    $reverse = false;
                }

                $total = 0;
                $matchesTotal = null;
                preg_match_all($regexTotal, $match['scores'], $matchesTotal, PREG_SET_ORDER, 0);
                foreach ($matchesTotal as $mch) {
                    $total += $mch['before'] + $mch['after'];
                }
                $passedTotalMore = $this->checkPassedTotalMore($totalArray, $total);
                $passedTotalLess = $this->checkPassedTotalLess($totalArray, $total);
                array_push($totalMore, $passedTotalMore);
                array_push($totalLess, $passedTotalLess);

                $scoreFirst = 0;
                $scoreSecond = 0;
                $matchesScoreFirst = null;
                preg_match_all($regexTotal, $match['scores'], $matchesScoreFirst, PREG_SET_ORDER, 0);
                foreach ($matchesScoreFirst as $mch) {
                    if ($reverse) {
                        $scoreFirst += $mch['after'];
                        $scoreSecond += $mch['before'];
                    } else {
                        $scoreFirst += $mch['before'];
                        $scoreSecond += $mch['after'];
                    }
                }

                $forFirst = $scoreFirst - $scoreSecond;
                $forSecond = $scoreSecond - $scoreFirst;
                array_push($forFirstArray, $this->checkPassedFor($forArray->firstPlayer, $forFirst));
                array_push($forSecondArray, $this->checkPassedFor($forArray->secondPlayer, $forSecond));
                array_push($individualTotalFirstMore, $this->checkPassedTotalMore($individualTotalFirstArray, $scoreFirst));
                array_push($individualTotalFirstLess, $this->checkPassedTotalLess($individualTotalFirstArray, $scoreFirst));

                array_push($individualTotalSecondMore, $this->checkPassedTotalMore($individualTotalSecondArray, $scoreSecond));
                array_push($individualTotalSecondLess, $this->checkPassedTotalLess($individualTotalSecondArray, $scoreSecond));
            }
            $response['total'] = $this->normallyView($totalMore, $totalLess);
            $response['individualTotalFirst'] = $this->normallyView($individualTotalFirstMore, $individualTotalFirstLess);
            $response['individualTotalSecond'] = $this->normallyView($individualTotalSecondMore, $individualTotalSecondLess);
            $response['forFirst'] = $this->normallyViewFor($forFirstArray);
            $response['forSecond'] = $this->normallyViewFor($forSecondArray);
            return response()->json($response, 200);
        }
        return response()->json([], 200);
    }
    //формирование фора
    private function checkPassedFor($lineFors, $for)
    {
        $response = [];
        foreach ($lineFors as $lineFor) {
            $currentFor = $for;
            if ($lineFor > 0) {
                $currentFor += $lineFor;
            } else if ($lineFor < 0) {
                $currentFor += $lineFor;
            } else if ($lineFor == 0) {
                $currentFor += $lineFor;
            }

            $array = [
                'value' => $currentFor,
                'linetotal' => strval($lineFor)
            ];
            array_push($response, $array);
        }
        return $response;
    }
    //формирования тотала больше
    private function checkPassedTotalMore($lineTotals, $total)
    {
        $response = [];
        foreach ($lineTotals as $lineTotal) {
            $array = [
                'value' => $total - $lineTotal,
                'linetotal' => strval($lineTotal)
            ];
            array_push($response, $array);
        }
        return $response;
    }
    //формирование тотала меньше
    private function checkPassedTotalLess($lineTotals, $total)
    {
        $response = [];
        foreach ($lineTotals as $lineTotal) {
            $array = [
                'value' => $lineTotal - $total,
                'linetotal' => strval($lineTotal)
            ];
            array_push($response, $array);
        }
        return $response;
    }
    //проверка массива значение
    private function checkArray($array, $name)
    {
        $response = false;
        foreach ($array as $key => $value) {
            if ($value['value'] == $name) {
                $response = $key;
                break;
            } else {
                $response = false;
            }
        }
        return $response;
    }
    //нормализация вида фора
    private function normallyViewFor($array)
    {
        $normallyArray = [];
        foreach ($array as $match) {
            foreach ($match as $total) {
                if (isset($total['linetotal'])) {
                    $exts = $this->checkArray($normallyArray, $total['linetotal']);
                    if ($exts == false && is_bool($exts)) {
                        $array = [
                            'value' => $total['linetotal'],
                            'number' => 0,
                        ];
                        if ($total['value'] > 0) {
                            $array['number'] = 1;
                        }
                        array_push($normallyArray, $array);
                    } else {
                        if ($total['value'] > 0) {
                            $normallyArray[$exts]['number']++;
                        }
                    }
                }
            }
        }
        return $normallyArray;
    }
    //нормализация вида остальных данных
    private function normallyView($firstArray, $secondArray)
    {
        $normallyArray = [];
        foreach ($firstArray as $match) {
            foreach ($match as $total) {
                if (isset($total['linetotal'])) {
                    $exts = $this->checkArray($normallyArray, $total['linetotal']);
                    if ($exts == false && is_bool($exts)) {
                        $array = [
                            'value' => $total['linetotal'],
                            'first' => 0,
                            'second' => 0,
                        ];
                        if ($total['value'] > 0) {
                            $array['first'] = 1;
                        }
                        array_push($normallyArray, $array);
                    } else {
                        if ($total['value'] > 0) {
                            $normallyArray[$exts]['first']++;
                        }
                    }
                }
            }
        }
        foreach ($secondArray as $match) {
            foreach ($match as $total) {
                $exts = $this->checkArray($normallyArray, $total['linetotal']);
                if (isset($total['linetotal'])) {
                    if ($exts == false && is_bool($exts)) {
                        $array = [
                            'value' => $total['linetotal'],
                            'first' => 0,
                            'second' => 0,
                        ];
                        if ($total['value'] > 0) {
                            $array['second'] = 1;
                        }
                        array_push($normallyArray, $array);
                    } else {
                        if ($total['value'] > 0) {
                            $normallyArray[$exts]['second']++;
                        }
                    }
                }
            }
        }
        return $normallyArray;
    }
}
