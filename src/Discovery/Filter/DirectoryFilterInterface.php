<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\File;

/**
 * Interface for directory filter implementations.
 *
 * @package Tozart\Discovery\Filter
 */
interface DirectoryFilterInterface {

  /**
   * Evaluate whether the given file passes the filter criteria.
   *
   * @param \Tozart\os\File $file
   *   The file to evaluate.
   *
   * @return bool
   *   TRUE if the file passes the filter.
   *   FALSE if it does not pass.
   */
  public function evaluate(File $file);

}
