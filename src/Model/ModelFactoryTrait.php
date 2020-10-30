<?php

namespace Tozart\Model;

use Tozart\Tozart;

/**
 * Provides dependency injection for the model factory service.
 *
 * @package Tozart\Model
 */
trait ModelFactoryTrait {

  /**
   * Inject the model factory service.
   *
   * @return \Tozart\Model\ModelFactory
   *   A model factory object.
   */
  protected static function modelFactory() {
    return Tozart::modelFactory();
  }

}
