<?php

namespace Fpl\Element;

use Fpl\Element;

class UserHistoryGameweek extends Element {

  public $gameweek;
  public $gameweek_points;
  public $gameweek_rank;
  public $transfers_made;
  public $transfers_cost;
  public $team_value;
  public $overall_points;
  public $overall_rank;

  public function populate($crawler) {
    $this->gameweek         = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol1 a')->text());
    $this->gameweek_points  = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol2')->text());
    $this->gameweek_rank    = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol3')->text());
    $this->transfers_made   = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol4')->text());
    $this->transfers_cost   = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol5')->text());
    $this->team_value       = (float) preg_replace('~[^0-9.]~', '', $crawler->filter('.ismCol6')->text());
    $this->overall_points   = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol7')->text());
    $this->overall_rank     = (int) preg_replace('~\D~', '', $crawler->filter('.ismCol8')->text());
  }

}