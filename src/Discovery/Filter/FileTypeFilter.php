<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\FileTypeInterface;

/**
 * Filter for sorting out files are of a file type different to the configured.
 *
 * @package Tozart\os
 */
class FileTypeFilter extends FileNamePatternFilter {

  /**
   * The file type by which to filter.
   *
   * @var \Tozart\os\FileTypeInterface
   */
  protected $_fileType;

  /**
   * Retrieve the file type by which to filter.
   *
   * @return \Tozart\os\FileTypeInterface
   *   A file type object.
   */
  protected function fileType() {
    return $this->_fileType;
  }

  /**
   * Create a new FileTypeFilter instance.
   *
   * @param \Tozart\os\FileTypeInterface $file_type
   *   A file type object.
   */
  public function __construct(FileTypeInterface $file_type) {
    $this->_fileType = $file_type;
    parent::__construct($this->buildPattern());
  }

  /**
   * Build the pattern that validates the filename.
   *
   * @return string
   *   A regular expression string.
   */
  protected function buildPattern() {
    $extensions = $this->fileType()->getExtensions();
    return str_replace('@extensions',
      implode('|', $extensions), '/.*\.(@extensions)/');
  }

}
