<?php

namespace Tozart\Validation;

use Tozart\Tozart;

/**
 * Dependency injection of the validator factory service.
 *
 * @package Tozart\Validation
 */
trait ValidatorFactoryTrait {

  /**
   * Inject the validator factory service.
   *
   * @return \Tozart\Validation\ValidatorFactoryInterface
   *   A validator factory instance.
   */
  public static function validatorFactory() {
    return Tozart::validatorFactory();
  }

}
