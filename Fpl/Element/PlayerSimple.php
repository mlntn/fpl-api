<?php

namespace Fpl\Element;

use Fpl\Element;

class PlayerSimple extends Element {

  /**
   * @var integer
   */
  public $player_id;

  /**
   * @var string
   */
  public $first_name;

  /**
   * @var string
   */
  public $last_name;

  /**
   * @var string
   */
  public $display_name;

  /**
   * @var Team
   */
  public $team;

  public function load($player_id) {
    $this->player_id = $player_id;

    $content = $this->getJson("http://fantasy.premierleague.com/web/api/elements/{$player_id}/");

    $this->first_name       = $content->first_name;
    $this->last_name        = $content->second_name;
    $this->display_name     = $content->web_name;

    $team = new Team();
    $team->load($content->team_id);
    $this->team             = $team;
  }

}