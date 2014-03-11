<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class League extends Element {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  /**
   * @var LeagueUser[]
   */
  public $users = array();

  public function load($league_id, $page) {
    $this->id = $league_id;

    $crawler = $this->getDom("http://fantasy.premierleague.com/my-leagues/{$league_id}/standings/" . ($page > 1 ? "?ls-page={$page}" : ''));

    $users = $crawler->filter('#ism .ismStandingsTable tr');
    foreach ($users as $i=>$ui) {
      if ($i === 0) continue;
      $u = new Crawler($ui);

      $user = new LeagueUser();
      $user->rank = (int) preg_replace('~\D~', '', $u->filterXPath('//td[2]')->text());
      $user->id = (int) preg_replace('~^/entry/(\d+)/.+?$~', '$1', $u->filterXPath('//td[3]/a')->attr('href'));
      $user->team = $u->filterXPath('//td[3]')->filter('a')->text();
      $user->user = $u->filterXPath('//td[4]')->text();
      $user->gameweek_points = (int) preg_replace('~\D~', '', $u->filterXPath('//td[5]')->text());
      $user->total_points = (int) preg_replace('~\D~', '', $u->filterXPath('//td[6]')->text());

      $this->users[] = $user;
    }

    $this->name = $crawler->filterXPath('//*[@id="ism"]/section/div/div/h2')->text();
  }

}