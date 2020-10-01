<?php

namespace Tozart\Discovery\Filter;

use Tozart\Tozart;

/**
 * Dependency injection for the directory filter factory service.
 *
 * @package Tozart\Discovery\Filter
 */
trait DirectoryFilterFactoryTrait {

  /**
   * Inject the directory filter factory service.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A directory filter factory instance.
   */
  protected static function directoryFilterFactory() {
    return Tozart::directoryFilterFactory();
  }

}
