<?php

namespace Fpl\Filter;

use Fpl\Filter;

class Between extends Filter
{

    protected $min;
    protected $max;

    public function __construct($key, $min, $max)
    {
        parent::__construct($key);

        $this->min = $min;
        $this->max = $max;
    }

    public function check($item)
    {
        return $item >= $this->min && $item <= $this->max;
    }
}
