<?php

namespace Fpl\Element;

use Fpl\Element;

class PlayerSimple extends Element {

  /**
   * @var integer
   */
  public $id;

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

  /**
   * @var Position
   */
  public $position;

  public function load($player_id) {
    $this->id = $player_id;

    $content = $this->getJson("http://fantasy.premierleague.com/web/api/elements/{$player_id}/");

    $this->first_name   = $content->first_name;
    $this->last_name    = $content->second_name;
    $this->display_name = $content->web_name;

    $team = new TeamSimple();
    $team->load($content->team_id);
    $this->team = $team;

    $position = new Position();
    $position->load($content->element_type_id);
    $this->position = $position;
  }

  public function populate($player) {
    $this->id             = $player[0];
    $this->first_name     = $player[3];
    $this->last_name      = $player[4];
    $this->display_name   = $player[5];

    $team = new TeamSimple();
    $team->load($player[57]);
    $this->team = $team;

    $position = new Position();
    $position->load($player[56]);
    $this->position = $position;
  }

}