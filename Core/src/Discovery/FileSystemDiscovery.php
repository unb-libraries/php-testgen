<?php

namespace Trupal\Core\Discovery;

use Trupal\Core\Discovery\Filter\DirectoryFilterInterface;
use Trupal\Core\os\DependencyInjection\FileSystemTrait;
use Trupal\Core\os\DirectoryInterface;

/**
 * Base class for discovery implementations.
 *
 * @package Trupal\Core\os
 */
class FileSystemDiscovery implements DiscoveryInterface {

  use FileSystemTrait;

  /**
   * Stack of directory roots in which to search for files.
   *
   * @var \Trupal\Core\os\DirectoryInterface[]
   */
  protected $_directoryStack = [];

  /**
   * Stack of directory filters.
   *
   * @var \Trupal\Core\Discovery\Filter\DirectoryFilterInterface[]
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
   * @param \Trupal\Core\os\DirectoryInterface|string $directory
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
   * @return \Trupal\Core\os\DirectoryInterface
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
   * @param \Trupal\Core\Discovery\Filter\DirectoryFilterInterface $filter
   *   A directory filter instance.
   */
  public function addFilter(DirectoryFilterInterface $filter) {
    $this->_filterStack[] = $filter;
  }

  /**
   * Grab the first filter from the stack.
   *
   * @return \Trupal\Core\Discovery\Filter\DirectoryFilterInterface $filter
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
   * @return \Trupal\Core\os\FileInterface
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
   * @param \Trupal\Core\os\DirectoryInterface $directory
   *   A directory instance.
   *
   * @return \Trupal\Core\os\FileInterface[]
   *   An array of the form FILENAME => SCORE, where score indicates how
   *   well the filename matches the filter criteria.
   *
   * @see \Trupal\Core\Discovery\Filter\DirectoryFilterInterface::evaluate()
   */
  protected function findIn(DirectoryInterface $directory) {
    $matches = [];
    foreach ($directory->files() as $filename => $file) {
      $all_passed = TRUE;
      foreach ($this->filterStack() as $filter) {
        $passed = $filter->evaluate($file);
        $all_passed = $all_passed && $passed;
      }
      if ($all_passed) {
        $matches[$file->path()] = $file;
      }
    }
    return $matches;
  }

}
