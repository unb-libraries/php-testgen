<?php

namespace Tozart\os;

use Tozart\os\DependencyInjection\FileSystemTrait;

/**
 * Base class for Locator implementations.
 *
 * @package Tozart\os
 */
class Locator {

  use FileSystemTrait;

  /**
   * Stack of directory roots in which to search for files.
   *
   * @var \Tozart\os\Directory[]
   */
  protected $_sourceStack = [];

  /**
   * Stack of directory filters.
   *
   * @var \Tozart\os\DirectoryFilterInterface[]
   */
  protected $_filterStack = [];

  /**
   * Retrieve the stack of directory roots in which to search for files.
   *
   * @return \Tozart\os\Directory[]
   *   An array of directories.
   */
  public function sourceStack() {
    return array_reverse($this->_sourceStack, TRUE);
  }

  /**
   * Retrieve the stack of directory filters.
   *
   * @return \Tozart\os\DirectoryFilterInterface[]
   *   An array of directory filter instances.
   */
  public function filterStack() {
    return array_reverse($this->_filterStack);
  }

  /**
   * Create a new Locator instance.
   *
   * @param array $directories
   *   Array of directories or paths.
   * @param array $filters
   *   Array of directory filters.
   */
  public function __construct(array $directories, array $filters = []) {
    $this->stackSourceRoots($directories);
    $this->stackFilters($filters);
  }

  /**
   * Add the given directories to the stack, in reverse order.
   *
   * @param array $directories
   *   An array of directory roots. The first element will be added last.
   */
  public function stackSourceRoots($directories) {
    foreach (array_reverse($directories) as $directory) {
      $this->stackSourceRoot($directory);
    }
  }

  /**
   * Add the given directory root to the stack.
   *
   * @param \Tozart\os\Directory|string $directory
   *   A directory or path.
   */
  public function stackSourceRoot(Directory $directory) {
    if (is_string($directory)) {
      $directory = $this->fileSystem()->dir($directory);
    }
    $this->_sourceStack[] = $directory;
  }

  /**
   * Grab the first element from the stack.
   *
   * @return \Tozart\os\Directory
   *   A directory instance.
   */
  public function popSourceRoot() {
    return array_pop($this->_sourceStack);
  }

  /**
   * Remove all directory roots from the stack.
   */
  public function clearSourceRoots() {
    $this->_sourceStack = [];
  }

  /**
   * Add the given filters to the stack, in reverse order.
   *
   * @param array $filters
   *   An array of directory filters. The first element will be added last.
   */
  public function stackFilters(array $filters) {
    foreach (array_reverse($filters) as $filter) {
      $this->stackFilter($filter);
    }
  }

  /**
   * Add the given directory filter to the stack.
   *
   * @param \Tozart\os\DirectoryFilterInterface $filter
   *   A directory filter instance.
   */
  public function stackFilter(DirectoryFilterInterface $filter) {
    $this->_filterStack[] = $filter;
  }

  /**
   * Grab the first filter from the stack.
   *
   * @return \Tozart\os\DirectoryFilterInterface $filter
   *   A directory filter instance.
   */
  public function popFilter() {
    return array_pop($this->_filterStack);
  }

  /**
   * Remove all filters from the stack.
   */
  public function clearFilters() {
    $this->_filterStack = [];
  }

  /**
   * Retrieve the best match out of all located files.
   *
   * @return \Tozart\os\File
   *   A file instance.
   */
  public function get() {
    return NULL;
  }

  /**
   * Locate files in any of the source roots that match the filter criteria.
   *
   * @return array
   *   An array of located filenames, grouped by the directory
   *   in which they were found.
   */
  public function find() {
    return [];
  }


}
