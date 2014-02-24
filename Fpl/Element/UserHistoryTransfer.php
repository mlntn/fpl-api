<?php

namespace Fpl\Element;

use Fpl\Element;

class UserHistoryTransfer extends Element {

  /**
   * @var DateTime
   */
  public $transfer_time;

  /**
   * @var integer
   */
  public $gameweek;

  /**
   * @var Player
   */
  public $player_out;

  /**
   * @var Player
   */
  public $player_in;

  public function populate($crawler) {
    $this->gameweek = $crawler->filterXPath('//td[4]')->text();
    $time = $crawler->filterXPath('//td[1]')->text();
    // TODO: calculate the year better
    $this->transfer_time = new \DateTime(date('c', strtotime(preg_replace('~(\d+) (\w+) (.+)~', '$2 $1 ' . ($this->gameweek >= 20 ? 2014 : 2013) . ' $3', $time))));
    $this->player_out = substr($crawler->filterXPath('//td[2]/a')->attr('href'), 1);
    $this->player_in = substr($crawler->filterXPath('//td[3]/a')->attr('href'), 1);
  }

}