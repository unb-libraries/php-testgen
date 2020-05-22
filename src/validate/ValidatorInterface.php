<?php

namespace Tozart\validate;

/**
 * Interface for validator implementations.
 *
 * @package Tozart\validate
 */
interface ValidatorInterface {

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
