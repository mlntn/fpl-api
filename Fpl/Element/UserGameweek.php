<?php

namespace Fpl\Element;

use Fpl\Element;

class UserGameweek extends Element {

  /**
   * @var integer
   */
  public $user_id;

  /**
   * @var integer
   */
  public $gameweek;

  /**
   * @var integer
   */
  public $transfers_made;

  /**
   * @var integer
   */
  public $transfers_cost;

  /**
   * @var integer
   */
  public $gameweek_rank;

  /**
   * @var integer
   */
  public $gameweek_points;

  /**
   * @var integer
   */
  public $average_points;

  /**
   * @var integer
   */
  public $highest_points;

  /**
   * @var integer
   */
  public $highest_player_id;

  /**
   * @var UserPlayerGameweek[]
   */
  public $players;

  public function load($user_id, $gameweek) {
    $this->user_id = $user_id;
    $this->gameweek = $gameweek;

    $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/event-history/{$gameweek}/");

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