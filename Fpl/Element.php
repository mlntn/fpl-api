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

}