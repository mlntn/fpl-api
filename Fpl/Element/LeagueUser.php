<?php

namespace Fpl\Element;

use Fpl\Element;
use Symfony\Component\DomCrawler\Crawler;

class LeagueUser extends UserSimple
{

    /**
     * @var integer
     */
    public $rank;

    public function load($user_id)
    {
        $this->user_id = $user_id;

        $crawler = $this->getDom("http://fantasy.premierleague.com/entry/{$user_id}/history/");

        $this->user_name       = $crawler->filter('.ismSection2')->text();
        $this->team_name       = $crawler->filter('.ismSection3')->text();
        $this->gameweek_points = (int)preg_replace('~\D~', '',
          $crawler->filterXPath('//*[@id="ism"]/section[2]/div[2]/div[2]/dl/dd[1]')->text());
        $this->total_points    = (int)preg_replace('~\D~', '',
          $crawler->filterXPath('//*[@id="ism"]/section[2]/div[2]/div[2]/dl/dd[4]/a')->text());
    }
}
