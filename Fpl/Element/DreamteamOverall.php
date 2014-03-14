<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class DreamteamOverall extends Element {

  /**
   * @var integer
   */
  public $total_score;

  /**
   * @var Player
   */
  public $top_player;

  /**
   * @var Player[]
   */
  public $players = array();

  public function load() {
    $crawler = $this->getDom("http://fantasy.premierleague.com/dreamteam/");

    $player_list = $crawler->filterXPath('//*[@id="ismDataElements"]/tr');

    foreach ($player_list as $p) {
      $pc = new Crawler($p);
      $values = $pc->filter('td');
      $player = new Player();
      $player_id = substr($values->eq(1)->filterXPath('//a')->attr('href'), 1);
      $player->load($player_id);
      $this->players[] = $player;
    }

    $top_player_id = substr($crawler->filterXPath('//*[@id="ism"]/section[1]/div[1]/div[1]/div[2]/div[2]/div/div[2]/h4/a')->attr('href'), 1);
    $this->top_player = new Player();
    $this->top_player->load($top_player_id);

    $total_score = $crawler->filterXPath('//*[@id="ism"]/section[1]/div[1]/div[1]/div[2]/div[1]/div/div');
    $this->total_score = (int) preg_replace('~\D~', '', $total_score->text());

  }

}