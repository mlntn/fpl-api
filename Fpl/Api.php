<?php

namespace Fpl;

use Fpl\Element;
use Cache\Provider as CacheProvider;

class Api {

  public function __construct(CacheProvider $cache) {
    Element::$cache = $cache;
  }

  /**
   * @param int $player_id
   * @return \Fpl\Element\Player
   */
  public function getPlayer($player_id) {
    $player = new Element\Player();
    $player->load($player_id);

    return $player;
  }

  /**
   * @param int $player_id
   * @param int $gameweek
   * @return \Fpl\Element\PlayerGameweek
   */
  public function getPlayerGameweek($player_id, $gameweek) {
    $player_gameweek = new Element\PlayerGameweek();
    $player_gameweek->load($player_id, $gameweek);

    return $player_gameweek;
  }

  /**
   * @param int $user_id
   * @param int $gameweek
   * @return \Fpl\Element\UserGameweek
   */
  public function getUserGameweek($user_id, $gameweek) {
    $user_gameweek = new Element\UserGameweek();
    $user_gameweek->load($user_id, $gameweek);

    return $user_gameweek;
  }

  /**
   * @param int $gameweek
   * @return \Fpl\Element\DreamteamGameweek
   */
  public function getDreamteamGameweek($gameweek) {
    $dreamteam_gameweek = new Element\DreamteamGameweek();
    $dreamteam_gameweek->load($gameweek);

    return $dreamteam_gameweek;
  }

  /**
   * @param int $league_id
   * @param int $page
   * @return \Fpl\Element\League
   */
  public function getLeague($league_id, $page = 1) {
    $league = new Element\League();
    $league->load($league_id, $page);

    return $league;
  }

  /**
   * @return Element\TeamSimple[]
   */
  public function getTeams() {
    $element = new Element();
    
    return $element->getTeams();
  }

  /**
   * @return Element\Position[]
   */
  public function getPositions() {
    $element = new Element();
    
    return $element->getPositions();
  }

  /**
   * @param int $position_id
   * @return \Fpl\Element\Position
   */
  public function getPosition($position_id) {
    $position = new Element\Position();
    $position->load($position_id);
    
    return $position;
  }

  /**
   * @param int $user_id
   * @return \Fpl\Element\User
   */
  public function getUser($user_id) {
    $user = new Element\User();
    $user->load($user_id);

    return $user;
  }

  /**
   * @param int $gameweek
   * @return \Fpl\Element\Gameweek
   */
  public function getGameweek($gameweek) {
    $gw = new Element\Gameweek();
    $gw->load($gameweek);

    return $gw;
  }

}