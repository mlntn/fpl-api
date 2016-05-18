<?php

namespace Fpl\Element;

use Fpl\Element;

class TeamSimple extends Element
{

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

    public function load($team_id)
    {
        $this->populate($this->getTeam($team_id));
    }

    public function populate($team)
    {
        $this->id   = $team->id;
        $this->name = $team->name;
        $this->abbr = $team->short_name;
        $this->icon = "http://cdn.ismfg.net/static/plfpl/img/badges/badge_{$team->id}.png";
    }
}
