<?php

namespace Trupal\Core\Validation;

/**
 * Interface for validator factory implementations.
 *
 * @package Trupal\Core\Validation
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
   * @return \Trupal\Core\Validation\ValidatorInterface
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
