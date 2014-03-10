<?php

namespace Fpl\Element;

class UserPlayerGameweek extends PlayerGameweek {

  /**
   * @var boolean
   */
  public $is_captain;

  /**
   * @var boolean
   */
  public $is_vice_captain;

  /**
   * @var boolean
   */
  public $is_starter;

  /**
   * @var integer
   */
  public $substitute_order = 0;

}