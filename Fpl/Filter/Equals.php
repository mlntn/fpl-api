<?php

namespace Fpl\Filter;

class Equals extends Contains {

  public function __construct($key, $values) {
    parent::__construct($key, array($values));
  }

}
