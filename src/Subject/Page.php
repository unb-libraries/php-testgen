<?php

namespace Trupal\Subject;

/**
 * Subject of type "page".
 *
 * @package Trupal\Subject
 */
class Page extends SubjectBase {

  /**
   * The path under which the page should be accessible.
   *
   * @var string
   */
  protected $path;

  /**
   * Retrieve the path under which the page should be accessible.
   *
   * @return string
   *   A URL formatted string.
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Set the path under which the page should be accessible.
   *
   * @param string $url
   *   A URL formatted string.
   */
  public function setPath($url) {
    $this->path = $url;
  }

}
