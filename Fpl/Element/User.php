<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class User extends Element {

  /**
   * @var integer
   */
  public $user_id;

  /**
   * @var string
   */
  public $user_name;

  /**
   * @var string
   */
  public $team_name;

  /**
   * @var Country
   */
  public $country;

  /**
   * @var Team
   */
  public $favorite_team;

  /**
   * @var UserGameweek[]
   */
  public $gameweeks = array();

  /**
   * @var UserTransfer[]
   */
  public $transfers = array();

  public function load($user_id) {
    $this->user_id = $user_id;

    $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/history/");

    $favorite_team = $crawler->filter('.ismRHSBadge');
    if (count($favorite_team)) {
      preg_match('~badge_(\d+)\.png$~', $favorite_team->attr('src'), $team_id);
      if (count($team_id) > 1) {
        $team = new Team();
        $team->load($content->$team_id[1]);
        $this->favorite_team = $team;
      }
    }

    $country = $crawler->filter('.ismRHSNat');
    if (count($country)) {
      preg_match('~flags/([A-Z]{2})\.gif~', $country->attr('src'), $country_code);
      if (count($country_code) > 1) {
        $this->country = $country_code[1];
      }
    }
    $this->user_name = $crawler->filter('.ismSection2')->text();
    $this->team_name = $crawler->filter('.ismSection3')->text();

    $this->populateGameweeks($crawler);

    $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/transfers/history/");

    $this->populateTransfers($crawler);
  }

  public function populateGameweeks($crawler) {
    foreach ($crawler->filterXPath('//*[@id="ism"]/section[1]/section[1]/table/tbody/tr') as $week) {
      $week = new Crawler($week);

      $gameweek = new UserHistoryGameweek();
      $gameweek->populate($week);

      $this->gameweeks[] = $gameweek;
    }
  }

  public function populateTransfers($crawler) {
    foreach ($crawler->filterXPath('//*[@id="ism"]/section[1]/table[1]/tbody/tr') as $t) {
      $t = new Crawler($t);
      $transfer = new UserHistoryTransfer();
      $transfer->populate($t);

      array_unshift($this->transfers, $transfer);
    }
  }

}