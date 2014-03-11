<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class UserSimple extends Element {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var string
   */
  public $user;

  /**
   * @var string
   */
  public $team;

  /**
   * @var int
   */
  public $gameweek_points;

  /**
   * @var int
   */
  public $total_points;

  public function load($user_id) {
    $this->id = $user_id;

    $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/history/");

    $this->user = $crawler->filter('.ismSection2')->text();
    $this->team = $crawler->filter('.ismSection3')->text();
    $this->gameweek_points = (int) preg_replace('~\D~', '', $crawler->filterXPath('//*[@id="ism"]/section[2]/div[2]/div[2]/dl/dd[1]')->text());
    $this->total_points = (int) preg_replace('~\D~', '', $crawler->filterXPath('//*[@id="ism"]/section[2]/div[2]/div[2]/dl/dd[4]/a')->text());
  }

}