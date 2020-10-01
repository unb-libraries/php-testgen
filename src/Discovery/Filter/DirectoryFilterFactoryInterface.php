<?php

namespace Tozart\Discovery\Filter;

/**
 * Interface for filter factory implementations.
 *
 * @package Tozart\Discovery\Filter
 */
interface DirectoryFilterFactoryInterface {

  /**
   * The type of filter to build.
   *
   * @param string $type
   *   A string.
   * @param array $configuration
   *   An array containing options to initially
   *   configure the filter.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterInterface
   */
  public function create(string $type, array $configuration);

  /**
   * Retrieve a mapping between filter types and their definition.
   *
   * @return array
   *   An array assigning a definition array to each filter type.
   */
  public function getSpecifications();

}
