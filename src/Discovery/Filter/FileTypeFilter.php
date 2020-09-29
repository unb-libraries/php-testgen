<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\FileType;

/**
 * Filter all files in a directory by file type.
 *
 * @package Tozart\os
 */
class FileTypeFilter extends FileNamePatternFilter {

  protected $_fileType;

  protected function fileType() {
    return $this->_fileType;
  }

  /**
   * {@inheritDoc}
   */
  public function __construct(FileType $file_type) {
    $this->_fileType = $file_type;
    parent::__construct($this->buildPattern());
  }

  protected function buildPattern() {
    $extensions = $this->fileType()->extensions();
    return str_replace('@extensions',
      implode('|', $extensions), '/.*\.(@extensions)/');
  }

}
