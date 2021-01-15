<?php

namespace Trupal\Validation;

use Trupal\Trupal;

/**
 * Dependency injection of the validator factory service.
 *
 * @package Trupal\Validation
 */
trait ValidatorFactoryTrait {

  /**
   * Inject the validator factory service.
   *
   * @return \Trupal\Validation\ValidatorFactoryInterface
   *   A validator factory instance.
   */
  public static function validatorFactory() {
    return Trupal::validatorFactory();
  }

}
