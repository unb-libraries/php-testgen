<?php

namespace Trupal\Core\Subject;

/**
 * Subject of type "page".
 *
 * @package Trupal\Core\Subject
 */
class Page extends SubjectBase {

  /**
   * The title of the page.
   *
   * @var
   */
  protected $title;

  /**
   * The path under which the page should be accessible.
   *
   * @var string
   */
  protected $path;

  /**
   * Paths to which the page may redirect.
   *
   * @var array
   */
  protected $redirects;

  /**
   * Retrieve the title of the page.
   *
   * @return string
   *   A string.
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Set the title of the page.
   *
   * @param string $title
   *   A string.
   */
  public function setTitle(string $title) {
    $this->title = $title;
  }

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

  /**
   * Get paths to which the page may redirect.
   *
   * @param string $event
   *   The event at which the page should redirect.
   *
   * @return string|false
   *   A path. False if no redirect exists for the given event.
   */
  public function getRedirect(string $event) {
    if (array_key_exists($event, $this->redirects)) {
      return $this->redirects[$event];
    }
    return FALSE;
  }

}
