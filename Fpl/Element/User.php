<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class User extends UserSimple {

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
    parent::load($user_id);

    $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/history/");

    $favorite_team = $crawler->filter('.ismRHSBadge');
    if (count($favorite_team)) {
      preg_match('~badge_(\d+)\.png$~', $favorite_team->attr('src'), $team_id);
      if (count($team_id) > 1) {
        $team = new Team;
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

    $this->populateGameweeks($crawler);

    $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/transfers/history/");

    $this->populateTransfers($crawler);

    $this->populateLeagues($crawler);
  }

  public function populateGameweeks($crawler) {
    foreach ($crawler->filterXPath('//*[@id="ism"]/section[1]/section[1]/table/tbody/tr') as $week) {
      $week = new Crawler($week);

      $gameweek = new UserHistoryGameweek;
      $gameweek->populate($week);

      $this->gameweeks[] = $gameweek;
    }
  }

  public function populateTransfers($crawler) {
    foreach ($crawler->filterXPath('//*[@id="ism"]/section[1]/table[1]/tbody/tr') as $t) {
      $t = new Crawler($t);
      $transfer = new UserHistoryTransfer;
      $transfer->populate($t);

      array_unshift($this->transfers, $transfer);
    }
  }

  public function populateLeagues($crawler) {
    $types = array();

    foreach ($crawler->filterXPath('//*[@class="ismSecondary"]/*[@class="ismTableHeading"]') as $h) {
      $c = new Crawler($h);
      if (preg_match('~ leagues$~', $c->text())) {
        $types[] = strtolower(preg_replace('~ leagues$~', '', $c->text()));
      }
    }

    foreach ($crawler->filterXPath('//*[@class="ismTable ismLeagueTable"]') as $i=>$t) {
      $table = new Crawler($t);
      $leagues = $table->filterXpath('//tbody/tr');
      foreach ($leagues as $l) {
        $c = new Crawler($l);
        $league = new UserLeague;
        $league->type = $types[$i];
        $league->populate($c);

        $this->leagues[] = $league;
      }
    }
  }

}