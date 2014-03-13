<?php

namespace Fpl\Element;

use Fpl\Element;

class Player extends PlayerSimple {

  const STAT_MINUTES_PLAYED      =  3;
  const STAT_GOALS_SCORED        =  4;
  const STAT_ASSISTS             =  5;
  const STAT_CLEAN_SHEETS        =  6;
  const STAT_GOALS_CONCEDED      =  7;
  const STAT_OWN_GOALS           =  8;
  const STAT_PENALTIES_SAVED     =  9;
  const STAT_PENALTIES_MISSED    = 10;
  const STAT_YELLOW_CARDS        = 11;
  const STAT_RED_CARDS           = 12;
  const STAT_SAVES               = 13;
  const STAT_BONUS_POINTS        = 14;
  const STAT_EA_SPORTS_PPI       = 15;
  const STAT_BONUS_POINTS_SYSTEM = 16;
  const STAT_POINTS              = 19;

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
  public $clean_sheets;

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
  public $penalties_missed;

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
  public $bonus_points;

  /**
   * @var integer
   */
  public $ea_sports_ppi;

  /**
   * @var integer
   */
  public $bonus_points_system;

  public function load($player_id) {
    parent::load($player_id);

    $content = $this->getJson("http://fantasy.premierleague.com/web/api/elements/{$player_id}/");

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

    $this->minutes_played      = $this->sumStat($content->fixture_history->all, self::STAT_MINUTES_PLAYED);
    $this->goals_scored        = $this->sumStat($content->fixture_history->all, self::STAT_GOALS_SCORED);
    $this->assists             = $this->sumStat($content->fixture_history->all, self::STAT_ASSISTS);
    $this->clean_sheets        = $this->sumStat($content->fixture_history->all, self::STAT_CLEAN_SHEETS);
    $this->goals_conceded      = $this->sumStat($content->fixture_history->all, self::STAT_GOALS_CONCEDED);
    $this->own_goals           = $this->sumStat($content->fixture_history->all, self::STAT_OWN_GOALS);
    $this->penalties_saved     = $this->sumStat($content->fixture_history->all, self::STAT_PENALTIES_SAVED);
    $this->penalties_missed    = $this->sumStat($content->fixture_history->all, self::STAT_PENALTIES_MISSED);
    $this->yellow_cards        = $this->sumStat($content->fixture_history->all, self::STAT_YELLOW_CARDS);
    $this->red_cards           = $this->sumStat($content->fixture_history->all, self::STAT_RED_CARDS);
    $this->saves               = $this->sumStat($content->fixture_history->all, self::STAT_SAVES);
    $this->bonus_points        = $this->sumStat($content->fixture_history->all, self::STAT_BONUS_POINTS);
    $this->ea_sports_ppi       = $this->sumStat($content->fixture_history->all, self::STAT_EA_SPORTS_PPI);
    $this->bonus_points_system = $this->sumStat($content->fixture_history->all, self::STAT_BONUS_POINTS_SYSTEM);
  }

  public function populate($player) {
    parent::populate($player);

    $this->is_dreamteam     = $player[25];
    $this->maximum_cost     = $player[11] / 10;
    $this->minimum_cost     = $player[12] / 10;
    $this->current_cost     = $player[10] / 10;
    $this->photo_url        = "http://cdn.ismfg.net/static/plfpl/img/shirts/photos/{$player[2]}.jpg";
    $this->shirt_image_url  = "http://cdn.ismfg.net/static/plfpl/img/shirts/shirt_{$player[57]}" . ($player[56] === 1 ? '_1' : '') . ".png";
    $this->owners           = $player[27];
    $this->owner_percentage = $player[28];
    $this->status           = $player[1];
    $this->total_points     = $player[36];
    $this->form             = $player[29];
    $this->transfers_in     = $player[31];
    $this->transfers_out    = $player[30];

    $this->minutes_played      = $player[42];
    $this->goals_scored        = $player[43];
    $this->assists             = $player[44];
    $this->clean_sheets        = $player[45];
    $this->goals_conceded      = $player[46];
    $this->own_goals           = $player[47];
    $this->penalties_saved     = $player[48];
    $this->penalties_missed    = $player[49];
    $this->yellow_cards        = $player[50];
    $this->red_cards           = $player[51];
    $this->saves               = $player[52];
    $this->bonus_points        = $player[53];
    $this->ea_sports_ppi       = $player[54];
    $this->bonus_points_system = $player[55];
  }

  protected function sumStat($rounds, $item) {
    $total = 0;

    foreach ($rounds as $r) {
      $total += $r[$item];
    }

    return $total;
  }

}