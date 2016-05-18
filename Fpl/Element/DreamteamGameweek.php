<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class DreamteamGameweek extends Element {

  /**
   * @var integer
   */
  public $gameweek;

  /**
   * @var integer
   */
  public $total_score;

  /**
   * @var PlayerGameweek
   */
  public $top_player;

  /**
   * @var PlayerGameweek[]
   */
  public $players = array();

  public function load($gameweek) {
    $this->gameweek = $gameweek;

    $crawler = $this->getDom("http://fantasy.premierleague.com/dreamteam/event/{$gameweek}/");

    $player_list = $crawler->filterXPath('//*[@id="ismDataElements"]/tr');

    foreach ($player_list as $p) {
      $pc = new Crawler($p);
      $values = $pc->filter('td');
      $player = new PlayerGameweek;
      $player_id = substr($values->eq(1)->filterXPath('//a')->attr('href'), 1);
      $player->load($player_id, $gameweek);
      $this->players[] = $player;
    }

    $top_player_id = substr($crawler->filterXPath('//*[@id="ism"]/section[1]/div[1]/div[1]/div[2]/div[2]/div/div[2]/h4/a')->attr('href'), 1);
    $this->top_player = new PlayerGameweek;
    $this->top_player->load($top_player_id, $gameweek);

    $total_score = $crawler->filterXPath('//*[@id="ism"]/section[1]/div[1]/div[1]/div[2]/div[1]/div/div');
    $this->total_score = (int) preg_replace('~\D~', '', $total_score->text());

  }

}