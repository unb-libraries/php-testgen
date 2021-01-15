<?php

namespace Trupal\Validation;

/**
 * Interface for validator implementations.
 *
 * @package Trupal\validate
 */
interface ValidatorInterface {

  /**
   * Retrieve the validator's identifier.
   *
   * @return string
   *   A string.
   */
  public static function getId();

  /**
   * Retrieve the definition of the validator.
   *
   * @return array
   *   An array.
   */
  public static function getSpecification();

  /**
   * Create a validator with the given configuration.
   *
   * @param array $configuration
   *   The configuration array.
   *
   * @return static
   *   A validator instance.
   */
  public static function create(array $configuration);

  /**
   * Validate the given object.
   *
   * @param mixed $object
   *   The object to validate.
   *
   * @return array
   *   An array of validation errors. An empty
   *   array indicates successful validation.
   */
  public function validate($object);

}
