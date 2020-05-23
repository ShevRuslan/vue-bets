<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Match;
use App\Models\Player;

class Repository extends Controller
{
    protected $match;
    protected $player;
    public function __construct(Match $match, Player $player){
        $this->player = $player;
        $this->match = $match;
    }
    
    public function getCreateList(){
        $opts = array(
            'http'=>array(
              'method'=>"GET",
              'header'=>"X-Requested-With: XMLHttpRequest" 
            )
          );
          $context = stream_context_create($opts);
          $url= json_decode(file_get_contents('https://1xstavka.ru/results/getMain?ID=10&date=2020-05-20', false, $context), true);
          $url = $url['results'];
          $array= array();
          foreach($url as $a){
            foreach($a as $b){
                $array[] = $b;
            }
          }
          $max = count($array);
          for ($i = 0; $i <=$max; $i++){
              $mx =count($array[$i]);
              for($k=0; $mx<= $mx; $k++){
                  $a = count($array[$i][$k]["Elems"]);
                  for($l=0; $l<=$a; $l++){
                    if($array[$i][$k]['Elems'][$l]['sportName'] == 'Настольный теннис'){
                        $ready[] = $array[$i][$k]['Elems'][$l];
                    }
                  }
                }
             }
             return $ready;
          foreach($url as $obj){
              if($obj =='Настольный теннис'){
                  $player1 = $this->player->where('name', $obj['opp1'])->first();
                  if(!$player1){
                      $player1 = new Player();
                      $player1['name'] = $obj['opp1'];
                      $player1->save();
                  }
                  $player2 = $this->player->where('name', $obj['opp2'])->first();
                  if(!$player2){
                      $player2 = new Player();
                      $player2['name'] = $obj['opp2'];
                      $player2->save();
                  }
                  $match = new Match();
                  $match["idgame"] = $obj["idgame"]; 
                  $match["sportId"] =$obj["sportId"];
                  $match["sportName"] =$obj["sportName"];
                  $match["champId"] =$obj["champId"];
                  $match["champName"] =$obj["champName"];
                  $match["nameGame"] =$obj["nameGame"];
                  $match["gameTyp"] =$obj["gameTyp"];
                  $match["opp1"] =$player1->id;
                  $match["opp2"] =$player2->id;
                  $match["ResultPriority"] =$obj["ResultPriority"];
                  $match["clid_opp1"] =$obj["clid_opp1"];
                  $match["clid_opp2"] =$obj["clid_opp2"];
                  $match["country"] =$obj["country"];
                  $match["idbetgames_main"] =$obj["idbetgames_main"];
                  $match["opp1Country"] =$obj["opp1Country"];
                  $match["opp2Country" ] =$obj["opp2Country"];
                  $match["dopScore"] =$obj["dopScore"];
                  $match["IdSubGame"] =$obj["IdSubGame"];
                  $match["date"] =$obj["date"];
                  $match["add_info"] =$obj["add_info"];
                  $match["scores"] =$obj["scores"][0];
                  $match->save();
              }
          }
        return 'готово';
    }


}