<?php

namespace Tozart\Discovery;

/**
 * Interface for factory implementations.
 *
 * @package Tozart\Discovery
 */
interface FactoryInterface {

  /**
   * Create an instance based on the given parameters.
   *
   * @param string $key
   *   A key identifying the resource that should be created.
   *
   * @return mixed
   *   An object.
   */
  public function create($key);

}
