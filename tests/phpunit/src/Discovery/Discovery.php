<?php

namespace Tozart\Test\Discovery;

use Tozart\Discovery\DiscoveryBase;

/**
 * Test discovery implementation.
 *
 * @package Tozart\Test\Discovery
 */
class Discovery extends DiscoveryBase {

  /**
   * {@inheritDoc}
   */
  public function findBy($key) {
    $finds = [];
    foreach ($this->discover() as $dir => $files) {
      $finds += $files;
    }
    return $finds;
  }

}
