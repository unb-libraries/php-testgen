<?php

namespace Trupal\Core\Discovery\Filter;

use Trupal\Core\Trupal;

/**
 * Dependency injection for the directory filter factory service.
 *
 * @package Trupal\Core\Discovery\Filter
 */
trait DirectoryFilterFactoryTrait {

  /**
   * Inject the directory filter factory service.
   *
   * @return \Trupal\Core\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A directory filter factory instance.
   */
  protected static function directoryFilterFactory() {
    return Trupal::directoryFilterFactory();
  }

}
