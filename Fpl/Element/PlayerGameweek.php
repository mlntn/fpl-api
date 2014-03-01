<?php

namespace Fpl\Element;

class PlayerGameweek extends PlayerSimple {

  /**
   * @var Match
   */
  public $match;

  /**
   * @var integer
   */
  public $minutes_played;

  /**
   * @var integer
   */
  public $goals_scored;

  /**
   * @var integer
   */
  public $assists;

  /**
   * @var integer
   */
  public $clean_sheet;

  /**
   * @var integer
   */
  public $goals_conceded;

  /**
   * @var integer
   */
  public $own_goals;

  /**
   * @var integer
   */
  public $penalties_saved;

  /**
   * @var integer
   */
  public $penalities_missed;

  /**
   * @var integer
   */
  public $yellow_cards;

  /**
   * @var integer
   */
  public $red_cards;

  /**
   * @var integer
   */
  public $saves;

  /**
   * @var integer
   */
  public $bonus;

  /**
   * @var integer
   */
  public $ea_sports_ppi;

  /**
   * @var integer
   */
  public $bonus_points_system;

  /**
   * @var integer
   */
  public $net_transfers;

  /**
   * @var float
   */
  public $value;

  /**
   * @var integer
   */
  public $points;

  /**
   * @var integer
   */

  public function load($player_id, $gameweek) {
    parent::load($player_id);

    $contents = $this->getJson("http://fantasy.premierleague.com/web/api/elements/{$player_id}/");

    $matches = $this->filterMatches($contents->fixture_history->all, $gameweek);
    $gw = $this->sumMatches($matches);

    $this->minutes_played      = $gw[3];
    $this->goals_scored        = $gw[4];
    $this->assists             = $gw[5];
    $this->clean_sheet         = $gw[6];
    $this->goals_conceded      = $gw[7];
    $this->own_goals           = $gw[8];
    $this->penalties_saved     = $gw[9];
    $this->penalities_missed   = $gw[10];
    $this->yellow_cards        = $gw[11];
    $this->red_cards           = $gw[12];
    $this->saves               = $gw[13];
    $this->bonus               = $gw[14];
    $this->ea_sports_ppi       = $gw[15];
    $this->bonus_points_system = $gw[16];
    $this->net_transfers       = $gw[17];
    $this->value               = $gw[18] / 10;
    $this->points              = $gw[19];
  }

  protected function sumMatches($matches) {
    $totals = array_fill(3, 17, 0);

    for ($i = 3; $i <= 19; $i++) {
      foreach ($matches as $m) {
        $totals[$i] = $i === 18 ? $m[$i] : $totals[$i] + $m[$i];
      }
    }

    return $totals;
  }

  protected function filterMatches($matches, $gameweek) {
    $return = array();

    foreach ($matches as $m) {
      if ($m[1] === $gameweek) {
        $return[] = $m;
      }
    }

    return $return;
  }

}