<?php

namespace Trupal\Test\Validation;

use Trupal\Validation\ValidatorInterface;

/**
 * Validator without real behaviour, for testing purposes.
 *
 * @package Trupal\Test\Validation
 */
class FakeValidator implements ValidatorInterface {

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'fake';
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
