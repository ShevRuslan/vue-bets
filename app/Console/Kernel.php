<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Date;
use App\Models\Match;
use App\Models\Champ;
use App\Models\Player;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {

            $lastDateUpdate = Date::first();
            $tennis = array();
            $dateMatch = Carbon::now()->format('Y-m-d');
            $dateYear = Carbon::parse($dateMatch)->year;

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
            $url = json_decode(file_get_contents("https://1xstavka.ru/results/getMain?showAll=true&date={$dateMatch}", false, $context), true);
            $response = $url['results'];
            
            if(isset($response)) {
            
                foreach ($response as $sport) {
                    if ($sport['Name'] == "Настольный теннис") {
                        $tennis = $sport;
                        break;
                    }
                }

                foreach ($tennis['Elems'] as $match) {
                    foreach ($match['Elems'] as $match) {
                        $currentMatch = Match::where('idgame', $match['idgame'])->first();
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
                        if(!$currentMatch) {   
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
                        }
                        if (isset($match['sub_games'])) {
                            $sub_games = $match['sub_games'];
                            foreach($sub_games as $sub_game) {
                                $currentSubMatch = Match::where('idgame', $sub_game["idgame"])->first();
                                if(!$currentSubMatch) {
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
                }
                $lastDateUpdate->date = Carbon::now()->format('Y.d.m H:i');
                $lastDateUpdate->save();
            }
        })->cron('0 */2 * * *');;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
