<?php

namespace Trupal\Model;

use Trupal\Discovery\FactoryBase;
use Trupal\Trupal;

/**
 * Factory for creating model instances.
 *
 * @package Trupal\Model
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
      $specification = Trupal::fileParserManager()->parse($filepath);
      if ($specification['type'] = $key) {
        return $specification;
      }
    }
    return FALSE;
  }

}
