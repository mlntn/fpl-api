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

  protected $data = [
    1 => [
      'id' => 1,
      'singular_name' => 'Goalkeeper',
      'plural_name' => 'Goalkeepers',
      'abbr' => 'GKP',
      'shirt_specific' => true,
    ],
    2 => [
      'id' => 2,
      'singular_name' => 'Defender',
      'plural_name' => 'Defender',
      'abbr' => 'DEF',
      'shirt_specific' => false,
    ],
    3 => [
      'id' => 3,
      'singular_name' => 'Midfielder',
      'plural_name' => 'Midfielder',
      'abbr' => 'MID',
      'shirt_specific' => false,
    ],
    4 => [
      'id' => 4,
      'singular_name' => 'Forward',
      'plural_name' => 'Forwards',
      'abbr' => 'FWD',
      'shirt_specific' => false,
    ],
  ];

  public function load($position_id) {
    $this->populate((object) $this->data[$position_id]);
  }

  public function populate($position) {
    $this->id             = $position->id;
    $this->singular_name  = $position->singular_name;
    $this->plural_name    = $position->plural_name;
    $this->abbr           = $position->abbr;
    $this->shirt_specific = $position->shirt_specific;
  }

}