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
   * An array of patterns, i.e. regular expressions.
   *
   * @var array
   */
  protected $_patternStack = [];

  /**
   * Retrieve the stack of patterns.
   *
   * @return array
   *   An array of strings.
   */
  protected function patternStack() {
    return array_reverse($this->_patternStack, TRUE);
  }

  /**
   * Create a new FileNamePatternFilter instance.
   *
   * @param array $patterns
   *   An array of regular expressions. The pattern with
   *   the highest priority should be the first element
   *   in the array.
   */
  public function __construct(array $patterns) {
    foreach (array_reverse($patterns) as $pattern) {
      $this->stackPattern($pattern);
    }
  }

  /**
   * Add the given pattern to the stack.
   *
   * @param string $pattern
   *   A regular expression string.
   */
  public function stackPattern($pattern) {
    $this->_patternStack[] = $pattern;
  }

  /**
   * Pop the first pattern from the stack.
   *
   * @return string
   *   A regular expression string.
   */
  public function popPattern() {
    return array_pop($this->_patternStack);
  }

  /**
   * Remove all patterns from the stack.
   */
  public function clearPatterns() {
    $this->_patternStack = [];
  }

  /**
   * {@inheritDoc}
   */
  public function match(File $file) {
    foreach ($this->patternStack() as $priority => $pattern) {
      if (preg_match($pattern, $file->name())) {
        return ($priority + 1) / count($this->patternStack());
      }
    }
    return 0;
  }

}
