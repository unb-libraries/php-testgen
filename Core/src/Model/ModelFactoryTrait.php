<?php

namespace Trupal\Model;

use Trupal\Trupal;

/**
 * Provides dependency injection for the model factory service.
 *
 * @package Trupal\Model
 */
trait ModelFactoryTrait {

  /**
   * Inject the model factory service.
   *
   * @return \Trupal\Model\ModelFactory
   *   A model factory object.
   */
  protected static function modelFactory() {
    return Trupal::modelFactory();
  }

}
