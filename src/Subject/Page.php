<?php

namespace Trupal\Subject;

/**
 * Subject of type "page".
 *
 * @package Trupal\Subject
 */
class Page extends SubjectBase {

  /**
   * The URL of the page.
   *
   * @var string
   */
  protected $_url;

  /**
   * Retrieve the URL of the page.
   *
   * @return string
   *   A URL formatted string.
   */
  public function getUrl() {
    return $this->_url;
  }

  /**
   * Set the URL of the page.
   *
   * @param string $url
   *   A URL formatted string.
   */
  public function setUrl($url) {
    $this->_url = $url;
  }

}
