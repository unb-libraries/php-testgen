<?php

namespace Trupal\Core\Test\Discovery\Filter;

use Trupal\Core\Discovery\Filter\DirectoryFilterInterface;
use Trupal\Core\os\FileInterface;

/**
 * Filter without real behaviour, for testing purposes.
 *
 * @package Trupal\Core\Test\Discovery\Filter
 */
class FakeFilter implements DirectoryFilterInterface {

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
    return 'fake';
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
