<?php

namespace Trupal\Core\Model;

use Trupal\Core\Trupal;

/**
 * Provides dependency injection for the model factory service.
 *
 * @package Trupal\Core\Model
 */
trait ModelFactoryTrait {

  /**
   * Inject the model factory service.
   *
   * @return \Trupal\Core\Model\ModelFactory
   *   A model factory object.
   */
  protected static function modelFactory() {
    return Trupal::modelFactory();
  }

}
