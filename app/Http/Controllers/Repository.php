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
          $tennis = array();
          foreach($url as $sport){
            if($sport['Name'] == "Настольный теннис") {
                $tennis = $sport;
                break;
            } 
          }
          foreach($tennis['Elems'] as $match) {
            foreach($match['Elems'] as $match) {
                $player1 = $this->player->where('name', $match['opp1'])->first();
                  if(!$player1){
                      $player1 = new Player();
                      $player1['name'] = $match['opp1'];
                      $player1->save();
                  }
                  $player2 = $this->player->where('name', $match['opp2'])->first();
                  if(!$player2){
                      $player2 = new Player();
                      $player2['name'] = $match['opp2'];
                      $player2->save();
                  }
                  $object = new Match();
                  $object["idgame"] = $match["idgame"]; 
                  $object["sportId"] =$match["sportId"];
                  $object["sportName"] =$match["sportName"];
                  $object["champId"] =$match["champId"];
                  $object["champName"] =$match["champName"];
                  $object["nameGame"] =$match["nameGame"];
                  $object["gameTyp"] =$match["gameTyp"];
                  $object["opp1"] =$player1->id;
                  $object["opp2"] =$player2->id;
                  $object["ResultPriority"] =$match["ResultPriority"];
                  $object["clid_opp1"] =$match["clid_opp1"];
                  $object["clid_opp2"] =$match["clid_opp2"]??null;
                  $object["country"] =$match["country"];
                  $object["idbetgames_main"] =$match["idbetgames_main"];
                  $object["opp1Country"] =$match["opp1Country"];
                  $object["opp2Country" ] =$match["opp2Country"];
                  $object["dopScore"] =$match["dopScore"];
                  $object["IdSubGame"] =$match["IdSubGame"];
                  $object["date"] =$match["date"];
                  $object["add_info"] =$match["add_info"];
                  $object["scores"] =$match["scores"][0];
                  $object->save();
            }
        }
        return 'готово';
    }


}