<?php

namespace Tozart\Validation;

use Tozart\Tozart;

trait ValidatorFactoryTrait {

  public static function validatorFactory() {
    return Tozart::validatorFactory();
  }

}