<?php

namespace Trupal\Core\Validation;

use Trupal\Core\Trupal;

/**
 * Dependency injection of the validator factory service.
 *
 * @package Trupal\Core\Validation
 */
trait ValidatorFactoryTrait {

  /**
   * Inject the validator factory service.
   *
   * @return \Trupal\Core\Validation\ValidatorFactoryInterface
   *   A validator factory instance.
   */
  public static function validatorFactory() {
    return Trupal::validatorFactory();
  }

}
