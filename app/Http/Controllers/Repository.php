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
                  $object["clid_opp1"] =$match["clid_opp1"]??null;
                  $object["clid_opp2"] =$match["clid_opp2"]??null;
                  $object["country"] =$match["country"];
                  $object["idbetgames_main"] =$match["idbetgames_main"];
                  $object["opp1Country"] =$match["opp1Country"]??null;
                  $object["opp2Country" ] =$match["opp2Country"]??null;
                  $object["dopScore"] =$match["dopScore"]??null;
                  $object["IdSubGame"] =$match["IdSubGame"];
                  $object["date"] =$match["date"];
                  $object["add_info"] =$match["add_info"];
                  $object["scores"] =$match["scores"][0];
                  $object->save();
                  if(isset($object['sub_games'])){
                        $sub_game = $object['sub_games'];
                        $sub_object = new Match();
                        $sub_object["idgame"] = $sub_game["idgame"]; 
                        $sub_object["sportId"] =$sub_game["sportId"];
                        $sub_object["sportName"] =$sub_game["sportName"];
                        $sub_object["champId"] =$sub_game["champId"];
                        $sub_object["champName"] =$sub_game["champName"];
                        $sub_object["nameGame"] =$sub_game["nameGame"];
                        $sub_object["gameTyp"] =$match["gameTyp"];
                        $sub_object["opp1"] =$player1->id;
                        $sub_object["opp2"] =$player2->id;
                        $sub_object["ResultPriority"] =$sub_game["ResultPriority"];
                        $sub_object["clid_opp1"] =$sub_game["clid_opp1"]??null;
                        $sub_object["clid_opp2"] =$sub_game["clid_opp2"]??null;
                        $sub_object["country"] =$sub_game["country"];
                        $sub_object["idbetgames_main"] =$object["idgame"];
                        $sub_object["opp1Country"] =$sub_game["opp1Country"]??null;
                        $sub_object["opp2Country" ] =$sub_game["opp2Country"]??null;
                        $sub_object["dopScore"] =$sub_game["dopScore"]??null;
                        $sub_object["IdSubGame"] =$match["IdSubGame"]??null;
                        $sub_object["date"] =$object["date"]??null;
                        $sub_object["add_info"] =$match["add_info"]??null;
                        $sub_object["scores"] =$sub_game["Trslt_result"];
                        $sub_object->save();
                  }
            }
        }
        return 'готово';
    }

    public function searchGame(Request $request)
    {
        $player1= $this->player->where('name', $request['player1'])->first();
        $player2= $this->player->where('name', $request['player2'])->first();
        
        $game1[0] = $this->match->where('opp1', $player1->id)->take(10)->get();
        $game1[1] = $this->match->where('opp2', $player1->id)->take(10)->get();
        $game2[0] = $this->match->where('opp1',$player2->id)->take(10)->get();
        $game2[1] = $this->match->where('opp2',$player2->id)->take(10)->get();
        $array =[$game1,$game2];
        return $array;
    }
}