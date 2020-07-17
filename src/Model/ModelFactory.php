<?php

namespace Tozart\Model;

use Tozart\Discovery\FactoryBase;

/**
 * Factory for creating model instances.
 *
 * @package Tozart\Model
 */
class ModelFactory extends FactoryBase {

  /**
   * {@inheritDoc}
   */
  protected function doCreate($specification) {
    $constructor = [Model::class, 'create'];
    return call_user_func($constructor, $specification);
  }

}
