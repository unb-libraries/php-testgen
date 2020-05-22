<?php

namespace Tozart\os;

/**
 * Filter all files in a directory by those of type YAML.
 *
 * @package Tozart\os
 */
class YamlFilter extends FileTypeFilter {

  /**
   * Create a new YamlFilter instance.
   */
  public function __construct() {
    parent::__construct(['yml', 'yaml']);
  }

}
