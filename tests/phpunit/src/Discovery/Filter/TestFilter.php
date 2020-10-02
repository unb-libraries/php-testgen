<?php

namespace Tozart\Test\Discovery\Filter;

use Tozart\Discovery\Filter\DirectoryFilterInterface;
use Tozart\os\FileInterface;

/**
 * Filter without real behaviour, for testing purposes.
 *
 * @package Tozart\Test\Discovery\Filter
 */

class TestFilter implements DirectoryFilterInterface {

  /**
   * {@inheritDoc}
   */
  public static function create(array $configuration) {
    return new static();
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'test';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [];
  }

  /**
   * {@inheritDoc}
   */
  public function evaluate(FileInterface $file) {
    return TRUE;
  }

}