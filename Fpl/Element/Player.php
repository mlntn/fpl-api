<?php

namespace Fpl\Element;

use Fpl\Element;

class Player extends Element {

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

  /**
   * @var boolean
   */
  public $is_dreamteam;

  /**
   * @var float
   */
  public $maximum_cost;

  /**
   * @var float
   */
  public $minimum_cost;

  /**
   * @var float
   */
  public $current_cost;

  /**
   * @var string
   */
  public $photo_url;

  /**
   * @var string
   */
  public $shirt_image_url;

  /**
   * @var integer
   */
  public $owners;

  /**
   * @var integer
   */
  public $owner_percentage;

  /**
   * @var string
   */
  public $status;

  /**
   * @var integer
   */
  public $total_points;

  /**
   * @var float
   */
  public $form;

  /**
   * @var integer
   */
  public $transfers_in;

  /**
   * @var integer
   */
  public $transfers_out;

  public function load($player_id) {
    $this->player_id = $player_id;

    $content = $this->getJson("http://fantasy.premierleague.com/web/api/elements/{$player_id}/");

    $this->first_name       = $content->first_name;
    $this->last_name        = $content->second_name;
    $this->display_name     = $content->web_name;

    $team = new Team();
    $team->load($content->team_id);
    $this->team             = $team;

    $this->is_dreamteam     = $content->in_dreamteam;
    $this->maximum_cost     = $content->max_cost / 10;
    $this->minimum_cost     = $content->min_cost / 10;
    $this->current_cost     = $content->now_cost / 10;
    $this->photo_url        = $content->photo_mobile_url;
    $this->shirt_image_url  = $content->shirt_image_url;
    $this->owners           = $content->selected;
    $this->owner_percentage = (float) $content->selected_by;
    $this->status           = $content->status;
    $this->total_points     = $content->total_points;
    $this->form             = $content->form;
    $this->transfers_in     = $content->transfers_in;
    $this->transfers_out    = $content->transfers_out;
  }

}