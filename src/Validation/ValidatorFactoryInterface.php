<?php

namespace Tozart\Validation;

/**
 * Interface for validator factory implementations.
 *
 * @package Tozart\Validation
 */
interface ValidatorFactoryInterface {

  /**
   * The type of validator to build.
   *
   * @param string $type
   *   A string.
   * @param array $configuration
   *   An array containing options to initially
   *   configure the validator.
   *
   * @return \Tozart\Validation\ValidatorInterface
   */
  public function create(string $type, array $configuration);

  /**
   * Retrieve the a between validator types and their definition.
   *
   * @return array
   *   An array assigning a definition array to each validator type.
   */
  public function getSpecifications();

}
