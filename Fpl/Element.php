<?php

namespace Fpl;

use Symfony\Component\DomCrawler\Crawler;

class Element {

  /**
   *
   * @param string $url
   * @return Symfony\Component\DomCrawler\Crawler
   */
  protected function getDom($url) {
    $html = file_get_contents($url);

    $crawler = new Crawler($html);

    return $crawler;
  }

  /**
   *
   * @param string $url
   * @return stdClass|array
   */
  protected function getJson($url) {
    $json = file_get_contents($url);

    $content = json_decode($json);

    return $content;
  }

}