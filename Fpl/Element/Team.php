<?php

namespace Fpl\Element;

use Fpl\Element;

class Team extends TeamSimple
{

    /**
     * @var Round[]
     */
    public $rounds;

    public function load($team_id)
    {
        parent::load($team_id);

        // todo: load rounds
    }
}
