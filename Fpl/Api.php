<?php

namespace Fpl;

use Fpl\Element;

class Api {

  public function getUserRound($user_id, $round) {

  }

  public function getPlayer($player_id) {
    $player = new Element\Player();
    $player->load($player_id);

    return $player;
  }

  public function getUserGameweek($user_id, $gameweek) {
    $user_gameweek = new Element\UserGameweek();
    $user_gameweek->load($user_id, $gameweek);

    return $user_gameweek;
  }

  public function getDreamteamGameweek($gameweek) {
    
  }

  public function getUser($user_id) {
    $user = new Element\User();
    $user->load($user_id);

    return $user;
  }

}