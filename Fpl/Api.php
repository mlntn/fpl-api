<?php

namespace Fpl;

use Fpl\Element;

class Api {

  public function getUserRound($user_id, $round) {

  }

  public function getPlayer($player_id) {

  }

  public function getRound($round) {

  }

  public function getUser($user_id) {
    $user = new Element\User();
    $user->load($user_id);

    return $user;
  }

}