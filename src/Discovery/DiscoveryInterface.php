<?php

namespace Tozart\Discovery;

/**
 * Interface for discovery implementations.
 *
 * @package Tozart\Discovery
 */
interface DiscoveryInterface {

  /**
   * Locate files in any of the source roots that match the filter criteria.
   *
   * @return array
   *   An array of located filenames, grouped by the directory
   *   in which they were found.
   */
  public function discover();

  /**
   * Retrieve the resource with the given key.
   *
   * @param string $key
   *   Key identifying the resource to retrieve.
   *
   * @return mixed|false
   *   An object. FALSE if no resource could
   *   be found.
   */
  public function findBy($key);

}
