<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class LeagueSimple extends Element {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  public function load($league_id) {
    $this->id = $league_id;
  }

}