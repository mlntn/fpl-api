<?php

namespace Fpl\Element;

use Fpl\Element;

class Team extends Element {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $abbr;

  /**
   * @var string
   */
  public $icon;

  /**
   * @var Round[]
   */
  public $rounds;

}