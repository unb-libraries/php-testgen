<?php

namespace Trupal\Core\Test\Validation;

use Trupal\Core\Validation\ValidatorInterface;

/**
 * Validator without real behaviour, for testing purposes.
 *
 * @package Trupal\Core\Test\Validation
 */
class TestValidator implements ValidatorInterface {

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'test';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [];
  }

  /**
   * {@inheritDoc}
   */
  public static function create(array $configuration) {
    return new static();
  }

  /**
   * {@inheritDoc}
   */
  public function validate($object) {
    return TRUE;
  }

}
