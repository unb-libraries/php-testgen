<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\FileInterface;

/**
 * Filter for sorting out files that do not match a configured name pattern.
 *
 * @package Tozart\Discovery\Filter
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
  public function __construct(string $pattern) {
    $this->_pattern = $pattern;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(array $configuration) {
    return new static($configuration['pattern']);
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'filename';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [
      'pattern' => '/.+/',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function evaluate(FileInterface $file) {
    return preg_match($this->getPattern(), $file->name());
  }

}
