<?php

namespace Fpl;

use Symfony\Component\DomCrawler\Crawler;

class Element {

  /**
   * @var \Cache\Provider
   */
  public static $cache;

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
    return strtr(str_replace('http://fantasy.premierleague.com/', '', $url), '/', '_');
  }

}