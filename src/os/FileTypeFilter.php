<?php

namespace Tozart\os;

/**
 * Filter all files in a directory by file type.
 *
 * @package Tozart\os
 */
class FileTypeFilter extends FileNamePatternFilter {

  /**
   * {@inheritDoc}
   */
  public function __construct($file_types) {
    $file_types = array_unique(array_map(function ($file_type) {
      return strtolower($file_type);
    }, $file_types));

    $pattern = str_replace('@file_types',
      implode('|', $file_types), '/.*\.(@file_types)/');

    parent::__construct([$pattern]);
  }

}
