<?php

namespace Fpl;

use Fpl\Element;
use Cache\Provider as CacheProvider;

class Api {

  public function __construct(CacheProvider $cache) {
    Element::$cache = $cache;
  }

  public function getPlayer($player_id) {
    $player = new Element\Player();
    $player->load($player_id);

    return $player;
  }

  public function getPlayerGameweek($player_id, $gameweek) {
    $player_gameweek = new Element\PlayerGameweek();
    $player_gameweek->load($player_id, $gameweek);

    return $player_gameweek;
  }

  public function getUserGameweek($user_id, $gameweek) {
    $user_gameweek = new Element\UserGameweek();
    $user_gameweek->load($user_id, $gameweek);

    return $user_gameweek;
  }

  public function getDreamteamGameweek($gameweek) {
    $dreamteam_gameweek = new Element\DreamteamGameweek();
    $dreamteam_gameweek->load($gameweek);

    return $dreamteam_gameweek;
  }

  public function getLeague($league_id, $page = 1) {
    $league = new Element\League();
    $league->load($league_id, $page);

    return $league;
  }

  public function getUser($user_id) {
    $user = new Element\User();
    $user->load($user_id);

    return $user;
  }

}