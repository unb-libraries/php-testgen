<?php

namespace Tozart\Model;

interface ModelInterface {

  /**
   * Create a new model instance.
   *
   * @param array $specification
   *   The model specification.
   * @return static
   */
  public static function create(array $specification);

}
