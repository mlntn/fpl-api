<?php

namespace Fpl\Element;

use Fpl\Element;

class Position extends Element {

  /**
   * @var int
   */
  public $id;

  /**
   * @var string
   */
  public $singular_name;

  /**
   * @var string
   */
  public $plural_name;

  /**
   * @var string
   */
  public $abbr;

  /**
   * @var boolean
   */
  public $shirt_specific;

  public function load($position_id) {
    $this->populate($this->getPosition($position_id));
  }

  public function populate($position) {
    $this->id = $position->id;
    $this->singular_name = $position->singular_name;
    $this->plural_name = $position->plural_name;
    $this->abbr = $position->singular_name_short;
    $this->shirt_specific = $position->shirt_specific;
  }
}