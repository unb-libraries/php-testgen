<?php

namespace Trupal\Core\Discovery;

use Trupal\Core\Discovery\Filter\DirectoryFilterInterface;

/**
 * Interface for discovery implementations.
 *
 * @package Trupal\Core\Discovery
 */
interface DiscoveryInterface {

  /**
   * Retrieve the stack of directory roots in which to search for files.
   *
   * @return \Trupal\Core\os\DirectoryInterface[]
   *   An array of directories.
   */
  public function directoryStack();

  /**
   * Add the given directories to the stack, in reverse order.
   *
   * @param array $directories
   *   An array of directory roots. The first element will be added last.
   */
  public function addDirectories(array $directories);

  /**
   * Add the given directory root to the stack.
   *
   * @param \Trupal\Core\os\DirectoryInterface|string $directory
   *   A directory or path.
   */
  public function addDirectory($directory);

  /**
   * Retrieve and remove the first element from the stack.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory instance.
   */
  public function popDirectory();

  /**
   * Remove all directory roots from the stack.
   */
  public function clearDirectories();

  /**
   * Retrieve the stack of directory filters.
   *
   * @return \Trupal\Core\Discovery\Filter\DirectoryFilterInterface[]
   *   An array of directory filter instances.
   */
  public function filterStack();

  /**
   * Add the given filters to the stack, in reverse order.
   *
   * @param array $filters
   *   An array of directory filters. The first element will be added last.
   */
  public function addFilters(array $filters);

  /**
   * Add the given directory filter to the stack.
   *
   * @param \Trupal\Core\Discovery\Filter\DirectoryFilterInterface $filter
   *   A directory filter instance.
   */
  public function addFilter(DirectoryFilterInterface $filter);

  /**
   * Grab the first filter from the stack.
   *
   * @return \Trupal\Core\Discovery\Filter\DirectoryFilterInterface $filter
   *   A directory filter instance.
   */
  public function popFilter();

  /**
   * Remove all filters from the stack.
   */
  public function clearFilters();

  /**
   * Locate files in any of the source roots that match the filter criteria.
   *
   * @return array
   *   An array of located filenames, grouped by the directory
   *   in which they were found.
   */
  public function discover();

}
