<?php

namespace Fpl\Element;

use Fpl\Element;

class UserLeague extends LeagueSimple {

  /**
   * classic, head-to-head, global
   * @var string
   */
  public $type;

  /**
   * @var integer
   */
  public $rank;

  /**
   * up, same, down
   * @var string
   */
  public $gameweek_movement;

  public function populate($crawler) {
    $league = $crawler->filterXpath('//td[3]/a');
    $league_id = (int) preg_replace('~/my-leagues/(\d+)/standings/~', '$1', $league->attr('href'));
    $this->name = $league->text();

    parent::load($league_id);

    $this->rank = (int) preg_replace('~\D~', '', $crawler->filterXpath('//td[2]')->text());
    $this->gameweek_movement = preg_replace('~.+?/([a-z]+)\.png$~', '$1', $crawler->filterXpath('//td[1]/img')->attr('src'));
  }

}