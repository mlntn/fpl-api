<?php

namespace Fpl\Filter;

use Fpl\Filter;

class Contains extends Filter {

  protected $values;

  public function __construct($key, array $values = array()) {
    parent::__construct($key);

    $this->values = $values;
  }

  public function check($item) {
    return in_array($item, $this->values);
  }

}
