<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\DirectoryFilterInterface;
use Tozart\os\DependencyInjection\FileSystemTrait;
use Tozart\os\DirectoryInterface;

/**
 * Base class for discovery implementations.
 *
 * @package Tozart\os
 */
abstract class DiscoveryBase implements DiscoveryInterface {

  use FileSystemTrait;

  /**
   * Stack of directory roots in which to search for files.
   *
   * @var \Tozart\os\DirectoryInterface[]
   */
  protected $_directoryStack = [];

  /**
   * Stack of directory filters.
   *
   * @var \Tozart\Discovery\Filter\DirectoryFilterInterface[]
   */
  protected $_filterStack = [];

  /**
   * {@inheritDoc}
   */
  public function directoryStack() {
    return array_reverse($this->_directoryStack, TRUE);
  }

  /**
   * {@inheritDoc}
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
    $this->addDirectories($directories);
    $this->addFilters($filters);
  }

  /**
   * Add the given directories to the stack, in reverse order.
   *
   * @param array $directories
   *   An array of directory roots. The first element will be added last.
   */
  public function addDirectories(array $directories) {
    foreach (array_reverse($directories) as $directory) {
      $this->addDirectory($directory);
    }
  }

  /**
   * Add the given directory root to the stack.
   *
   * @param \Tozart\os\DirectoryInterface|string $directory
   *   A directory or path.
   */
  public function addDirectory($directory) {
    if (is_string($directory)) {
      $directory = $this->fileSystem()->dir($directory);
    }
    $this->_directoryStack[] = $directory;
  }

  /**
   * Retrieve and remove the first element from the stack.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory instance.
   */
  public function popDirectory() {
    return array_pop($this->_directoryStack);
  }

  /**
   * Remove all directory roots from the stack.
   */
  public function clearDirectories() {
    $this->_directoryStack = [];
  }

  /**
   * Add the given filters to the stack, in reverse order.
   *
   * @param array $filters
   *   An array of directory filters. The first element will be added last.
   */
  public function addFilters(array $filters) {
    foreach (array_reverse($filters) as $filter) {
      $this->addFilter($filter);
    }
  }

  /**
   * Add the given directory filter to the stack.
   *
   * @param \Tozart\Discovery\Filter\DirectoryFilterInterface $filter
   *   A directory filter instance.
   */
  public function addFilter(DirectoryFilterInterface $filter) {
    $this->_filterStack[] = $filter;
  }

  /**
   * Grab the first filter from the stack.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterInterface $filter
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
    if (!empty($files = $this->discover())) {
      return $files[array_keys($files)[0]];
    }
    return NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function discover() {
    $files = [];
    foreach ($this->directoryStack() as $directory) {
      $files += $this->findIn($directory);
    }
    return $files;
  }

  /**
   * Find files inside the given directory that match the filter criteria.
   *
   * @param \Tozart\os\DirectoryInterface $directory
   *   A directory instance.
   *
   * @return \Tozart\os\File[]
   *   An array of the form FILENAME => SCORE, where score indicates how
   *   well the filename matches the filter criteria.
   *
   * @see \Tozart\Discovery\Filter\DirectoryFilterInterface::evaluate()
   */
  protected function findIn(DirectoryInterface $directory) {
    $matches = [];
    foreach ($directory->files() as $file) {
      $passed = TRUE;
      foreach ($this->filterStack() as $filter) {
        $passed = $passed && $filter->evaluate($file);
      }
      if ($passed) {
        $matches[$file->path()] = $file;
      }
    }
    return $matches;
  }

}
