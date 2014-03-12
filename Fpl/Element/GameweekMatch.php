<?php

namespace Fpl\Element;

use Fpl\Element;

class GameweekMatch extends Element {

  /**
   * @var \DateTime
   */
  public $start_time;

  /**
   * @var TeamSimple
   */
  public $home_team;

  /**
   * @var TeamSimple
   */
  public $away_team;

}