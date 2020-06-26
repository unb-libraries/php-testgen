<?php

namespace Tozart\Model;

/**
 * Public interface for model factory implementations.
 *
 * @package Tozart\Model
 */
interface ModelFactoryInterface {

  /**
   * Create a model of the given type.
   *
   * @param string $type
   *   A string.
   *
   * @return \Tozart\Model\ModelInterface
   *   A model instance.
   */
  public function create($type);

}
