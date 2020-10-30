<?php

namespace Tozart\Discovery;

/**
 * Interface for discovery implementations.
 *
 * @package Tozart\Discovery
 */
interface DiscoveryInterface {

  /**
   * Retrieve the stack of directory roots in which to search for files.
   *
   * @return \Tozart\os\DirectoryInterface[]
   *   An array of directories.
   */
  public function directoryStack();

  /**
   * Retrieve the stack of directory filters.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterInterface[]
   *   An array of directory filter instances.
   */
  public function filterStack();

  /**
   * Locate files in any of the source roots that match the filter criteria.
   *
   * @return array
   *   An array of located filenames, grouped by the directory
   *   in which they were found.
   */
  public function discover();

}
