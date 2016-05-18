<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class Gameweek extends Element {

  /**
   * @var integer
   */
  public $gameweek;

  /**
   * @var \DateTime
   */
  public $deadline_time;

  /**
   * @var GameweekMatch[]
   */
  public $matches = array();

  public function load($gameweek) {
    $this->gameweek = $gameweek;

    $crawler = $this->getDom("http://fantasy.premierleague.com/fixtures/{$gameweek}/", array('X-Requested-With'=>'XMLHttpRequest'));

    $deadline = $crawler->filter('.ismStrongCaption')->text();
    $this->deadline_time = $this->parseDate(array_pop(explode(' - ', $deadline)));
    $games = $crawler->filter('.ismFixture');

    foreach ($games as $g) {
      $gc = new Crawler($g);
      $match = new GameweekMatch;
      $home_team_id = (int) preg_replace('~^.+badge_(\d+).+$~', '$1', $gc->filterXpath('//td[3]/img')->attr('src'));
      $away_team_id = (int) preg_replace('~^.+badge_(\d+).+$~', '$1', $gc->filterXpath('//td[5]/img')->attr('src'));
      $match->home_team = new TeamSimple;
      $match->home_team->load($home_team_id);
      $match->away_team = new TeamSimple;
      $match->away_team->load($away_team_id);
      $match->start_time = $this->parseDate($gc->filterXpath('//td[1]')->text());

      $this->matches[] = $match;
    }
    
  }

}