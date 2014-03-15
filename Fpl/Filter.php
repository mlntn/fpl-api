<?php

namespace Fpl;

abstract class Filter implements FilterInterface {

  private $key;

  public function __construct($key) {
    $this->key = $key;
  }

  public function getKey() {
    return $this->key;
  }

}