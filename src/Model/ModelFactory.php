<?php

namespace Tozart\Model;

use Tozart\Discovery\FactoryBase;
use Tozart\Tozart;

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
    $constructor = [$specification['class'], 'create'];
    return call_user_func($constructor, $specification);
  }

  /**
   * Find a model specification for the given type.
   *
   * @param string $key
   *   A string.
   *
   * @return array|false
   *   A specification array. FALSE if no specification
   *   exists for the given type.
   */
  protected function findSpecification($key) {
    foreach ($this->discovery()->discover() as $filepath) {
      $specification = Tozart::fileParserManager()->parse($filepath);
      if ($specification['type'] = $key) {
        return $specification;
      }
    }
    return FALSE;
  }

}
