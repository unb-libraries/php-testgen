<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\File;

/**
 * Filename based directory filter implementation.
 *
 * @package Tozart\os
 */
class FileNamePatternFilter implements DirectoryFilterInterface {

  /**
   * A regular regular expressions describing a filename pattern.
   *
   * @var string
   */
  protected $_pattern;

  /**
   * Retrieve the filename pattern.
   *
   * @return string
   *   A regular expression string.
   */
  public function getPattern() {
    return $this->_pattern;
  }

  /**
   * Create a new FileNamePatternFilter instance.
   *
   * @param string $pattern
   *   A regular expression string.
   */
  public function __construct($pattern) {
    $this->_pattern = $pattern;
  }

  /**
   * {@inheritDoc}
   */
  public function match(File $file) {
    return preg_match($this->getPattern(), $file->name());
  }

}
