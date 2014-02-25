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
      $player = new PlayerGameweek();
      $player_id = substr($values->eq(1)->filterXPath('//a')->attr('href'), 1);
      $player->load($player_id, $gameweek);
      $this->players[] = $player;
    }
    die(var_dump($this->players));

    preg_match('~(\d+)\s+(\(\-(\d+)pts\))?~', $crawler->filterXPath('//*[@id="ism"]/section[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div/div[2]/dl/dd[2]')->text(), $transfers);
    $this->transfers_made = (int) $transfers[1];
    $this->transfers_cost = (int) @$transfers[3] ?: 0;
    $this->gameweek_rank = (int) preg_replace('~\D~', '', $crawler->filterXPath('//*[@id="ism"]/section[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div/div[2]/dl/dd[1]')->text());
    $this->gameweek_points = (int) preg_replace('~\D~', '', $crawler->filterXPath('//*[@id="ism"]/section[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div/div[1]/div/div')->text());
    $this->average_points = (int) preg_replace('~\D~', '', $crawler->filterXPath('//*[@id="ism"]/section[1]/div[3]/div[1]/div[2]/div[1]/div[1]/div/div[2]/div/div[2]')->text());
    $this->highest_points = (int) preg_replace('~\D~', '', $crawler->filterXPath('//*[@id="ism"]/section[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div/div[1]/div/div[2]/a')->text());
    $this->highest_player_id = (int) preg_replace('~/entry/(\d+)/~', '$1', $crawler->filterXPath('//*[@id="ism"]/section[1]/div[3]/div[1]/div[2]/div[1]/div[2]/div/div[1]/div/div[2]/a')->attr('href'));
    
  }

}