<?php

namespace Fpl;

use \DateTime;
use \DateTimeZone;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Element
{

    /**
     * @var \Cache\Provider
     */
    public static $cache;

    /**
     * @var \Goutte\Client
     */
    protected $client;

    protected $is_logged_in = false;

    public function __construct()
    {
        $this->client = new Client;
    }

    protected function login()
    {
        $page = $this->client->request('GET', 'http://fantasy.premierleague.com/');
        $form = $page->selectButton('Log In')->form();
        $this->client->submit($form, [
          'email'    => Config::$username,
          'password' => Config::$password,
          'success'  => 'http://fantasy.premierleague.com/accounts/login/',
          'fail'     => 'http://fantasy.premierleague.com/?fail',
        ]);

        $this->is_logged_in = true;
    }

    protected function getTransferJson()
    {
        if (self::$cache->has('transfers')) {
            $json = self::$cache->get('transfers');
        } else {
            if ($this->is_logged_in === false) {
                $this->login();
            }

            $info_page = $this->client->request('GET', 'http://fantasy.premierleague.com/transfers');
            $info_json = $info_page->filterXPath('//*[@id="ismJson"]/script')->text();
            $json      = json_decode($info_json);

            self::$cache->set('transfers', $json);
        }

        return $json;
    }

    protected function getTeamsRaw()
    {
        if (self::$cache->has('teams')) {
            $teams = self::$cache->get('teams');
        } else {
            $json  = $this->getTransferJson();
            $teams = $json->eiwteams;
            self::$cache->set('teams', $teams);
        }

        return $teams;
    }

    protected function getTeam($team_id)
    {
        $teams = $this->getTeamsRaw();

        return $teams->$team_id;
    }

    public function getTeams()
    {
        $teams = $this->getTeamsRaw();

        $return = [];

        foreach ($teams as $t) {
            $team = new Element\TeamSimple;
            $team->populate($t);
            $return[] = $team;
        }

        return $return;
    }

    protected function getPositionsRaw()
    {
        if (self::$cache->has('positions')) {
            $positions = self::$cache->get('positions');
        } else {
            $json      = $this->getTransferJson();
            $positions = $json->typeInfo;
            self::$cache->set('positions', $positions);
        }

        return $positions;
    }

    protected function getPosition($position_id)
    {
        $positions = $this->getPositionsRaw();

        return $positions[$position_id];
    }

    public function getPositions()
    {
        $positions = $this->getPositionsRaw();

        $return = [];

        foreach ($positions as $p) {
            if (is_null($p)) {
                continue;
            }
            $position = new Element\Position;
            $position->populate($p);
            $return[] = $position;
        }

        return $return;
    }

    protected function getPlayersRaw()
    {
        if (self::$cache->has('players')) {
            $players = self::$cache->get('players');
        } else {
            $json    = $this->getTransferJson();
            $players = $json->elInfo;
            self::$cache->set('players', $players);
        }

        return $players;
    }

    public function getPlayers(Filter $filter = null)
    {
        $players = $this->getPlayersRaw();

        $return = [];

        foreach ($players as $p) {
            if (is_null($p)) {
                continue;
            }
            $player = new Element\Player;
            $player->populate($p);
            if (is_null($filter) === false) {
                $key = $filter->getKey();
                if ($filter->check($player->$key) === false) {
                    continue;
                }
            }
            $return[] = $player;
        }

        return $return;
    }

    /**
     *
     * @param string $url
     * @return Symfony\Component\DomCrawler\Crawler
     */
    protected function getDom($url, $headers = [])
    {
        $html = $this->getContents($url, $headers, true);

        $crawler = new Crawler($html);

        return $crawler;
    }

    /**
     *
     * @param string $url
     * @return stdClass|array
     */
    protected function getJson($url)
    {
        $json = $this->getContents($url);

        $content = json_decode($json);

        return $content;
    }

    protected function getContents($url, $headers = [], $as_html = false)
    {
        $key = $this->buildCacheKey($url);

        if (self::$cache->has($key)) {
            return self::$cache->get($key);
        }

        if ($as_html) {
            foreach ($headers as $k => $v) {
                $this->client->setHeader($k, $v);
            }

            $contents = $this->client->request('GET', $url)->html();

            foreach ($headers as $k => $v) {
                $this->client->removeHeader($k);
            }
        } else {
            $contents = file_get_contents($url);
        }

        self::$cache->set($key, $contents);

        return $contents;
    }

    protected function buildCacheKey($url)
    {
        return strtr(str_replace('http://fantasy.premierleague.com/', '', trim($url, '/')), '/=?', '_--');
    }

    public function parseDate($date)
    {
        $date = preg_replace('~^(\d+) ([A-z]+) (\d{2}:\d{2})$~', '$2 $1 $3', $date);
        $dt   = new DateTime($date);

        $add = 0;
        if (date('m') > 7 && $dt->format('m') <= 7) {
            $add = 1;
        } elseif (date('m') <= 7 && $dt->format('m') > 7) {
            $add = -1;
        }

        $final_dt = new DateTime(date('Y-m-d H:i',
          mktime($dt->format('H'), $dt->format('i'), 0, $dt->format('n'), $dt->format('j'), $dt->format('Y') + $add)),
          new DateTimeZone('GMT'));

        return $final_dt;
    }
}
