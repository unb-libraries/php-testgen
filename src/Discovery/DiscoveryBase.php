<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\DirectoryFilterInterface;
use Tozart\os\DependencyInjection\FileSystemTrait;
use Tozart\os\Directory;

/**
 * Base class for Locator implementations.
 *
 * @package Tozart\os
 */
abstract class DiscoveryBase implements DiscoveryInterface {

  use FileSystemTrait;

  /**
   * Stack of directory roots in which to search for files.
   *
   * @var \Tozart\os\Directory[]
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
  public function addDirectories($directories) {
    foreach (array_reverse($directories) as $directory) {
      $this->addDirectory($directory);
    }
  }

  /**
   * Add the given directory root to the stack.
   *
   * @param \Tozart\os\Directory|string $directory
   *   A directory or path.
   */
  public function addDirectory($directory) {
    if (is_string($directory)) {
      $directory = $this->fileSystem()->dir($directory);
    }
    $this->_directoryStack[] = $directory;
  }

  /**
   * Grab the first element from the stack.
   *
   * @return \Tozart\os\Directory
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
      $most_important_directory_path = array_keys($files)[0];
      $most_important_directory_content = $files[$most_important_directory_path];
      asort($most_important_directory_content);
      $best_match = array_keys($most_important_directory_content)[0];

      return $this->fileSystem()
        ->dir($most_important_directory_path)
        ->find($best_match);
    }
    return NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function discover() {
    $files = [];
    foreach ($this->directoryStack() as $directory) {
      foreach ($this->findIn($directory) as $match) {
        /** @var \Tozart\os\File $file */
        $file = $match['file'];
        $files[$file->path()] = $file;
      }
    }
    return $files;
  }

  /**
   * Find files inside the given directory that match the filter criteria.
   *
   * @param \Tozart\os\Directory $directory
   *   A directory instance.
   *
   * @return \Tozart\os\File[]
   *   An array of the form FILENAME => SCORE, where score indicates how
   *   well the filename matches the filter criteria.
   *
   * @see \Tozart\Discovery\Filter\DirectoryFilterInterface::match()
   */
  protected function findIn(Directory $directory) {
    $matches = [];
    foreach ($directory->files() as $file) {
      $score = 1.0;
      foreach ($this->filterStack() as $filter) {
        $score *= $filter->match($file);
      }
      if ($score > 0) {
        $matches[$file->path()] = [
          'file' => $file,
          // TODO: Remove calculating a score. No longer needed.
          'score' => intval($score * 100),
        ];
      }
    }
    uasort($matches, function ($m1, $m2) {
      return $m1['score'] - $m2['score'];
    });
    return $matches;
  }

}
