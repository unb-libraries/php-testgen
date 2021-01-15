<?php

namespace Trupal\Discovery\Filter;

use Trupal\Trupal;

/**
 * Dependency injection for the directory filter factory service.
 *
 * @package Trupal\Discovery\Filter
 */
trait DirectoryFilterFactoryTrait {

  /**
   * Inject the directory filter factory service.
   *
   * @return \Trupal\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A directory filter factory instance.
   */
  protected static function directoryFilterFactory() {
    return Trupal::directoryFilterFactory();
  }

}
