<?php

namespace Trupal\Discovery\Filter;

use Trupal\os\FileInterface;

/**
 * Interface for directory filter implementations.
 *
 * @package Trupal\Discovery\Filter
 */
interface DirectoryFilterInterface {

  /**
   * Create a filter with the given configuration.
   *
   * @param array $configuration
   *   The configuration array.
   *
   * @return static
   *   A filter instance.
   */
  public static function create(array $configuration);

  /**
   * Retrieve the filter's identifier.
   *
   * @return string
   *   A string.
   */
  public static function getId();

  /**
   * Retrieve the definition of the filter.
   *
   * @return array
   *   An array.
   */
  public static function getSpecification();

  /**
   * Evaluate whether the given file passes the filter criteria.
   *
   * @param \Trupal\os\FileInterface $file
   *   The file to evaluate.
   *
   * @return bool
   *   TRUE if the file passes the filter.
   *   FALSE if it does not pass.
   */
  public function evaluate(FileInterface $file);

}
