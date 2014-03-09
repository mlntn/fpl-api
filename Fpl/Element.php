<?php

namespace Fpl;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Element {

  /**
   * @var \Cache\Provider
   */
  public static $cache;

  protected $is_logged_in = false;

  /**
   * @var Client
   */
  protected $client;

  protected function login() {
    $this->client = new Client();
    $page = $this->client->request('GET', 'http://fantasy.premierleague.com/');
    $form = $page->selectButton('Log In')->form();
    $this->client->submit($form, array(
      'email' => Config::$username,
      'password' => Config::$password,
      'success' => 'http://fantasy.premierleague.com/accounts/login/',
      'fail' => 'http://fantasy.premierleague.com/?fail',
    ));

    $this->is_logged_in = true;
  }

  protected function getTransferJson(){
    $json = self::$cache->get('transfers');

    if (empty($json)) {
      if ($this->is_logged_in === false) {
        $this->login();
      }

      $info_page = $this->client->request('GET', 'http://fantasy.premierleague.com/transfers');
      $info_json = $info_page->filterXPath('//*[@id="ismJson"]/script')->text();
      $json = json_decode($info_json);

      self::$cache->set('transfers', $json);
    }

    return $json;
  }

  protected function getTeam($team_id) {
    $teams = self::$cache->get('teams');

    if (empty($teams)) {
      $json = $this->getTransferJson();
      $teams = $json->eiwteams;
      self::$cache->set('teams', $teams);
    }

    return $teams->$team_id;
  }

  /**
   *
   * @param string $url
   * @return Symfony\Component\DomCrawler\Crawler
   */
  protected function getDom($url) {
    $html = $this->getContents($url);

    $crawler = new Crawler($html);

    return $crawler;
  }

  /**
   *
   * @param string $url
   * @return stdClass|array
   */
  protected function getJson($url) {
    $json = $this->getContents($url);

    $content = json_decode($json);

    return $content;
  }

  protected function getContents($url) {
    $key = $this->buildCacheKey($url);

    if (self::$cache->has($key)) {
      return self::$cache->get($key);
    }

    $contents = file_get_contents($url);

    self::$cache->set($key, $contents);

    return $contents;
  }

  protected function buildCacheKey($url) {
    return strtr(str_replace('http://fantasy.premierleague.com/', '', trim($url, '/')), '/', '_');
  }

}