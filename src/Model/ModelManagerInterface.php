<?php

namespace Tozart\Model;

/**
 * Interface for model manager implementations.
 *
 * @package Tozart\Model
 */
interface ModelManagerInterface {

  /**
   * Retrieve all models.
   *
   * @return \Tozart\Model\ModelInterface[]
   *   An array of model instances, keyed
   *   by their types.
   */
  public function models();

  /**
   * Whether a model of the given type is known to the manager.
   *
   * @param string $type
   *   The type.
   *
   * @return bool
   *   TRUE if the manager is aware of a model with
   *   the given type. FALSE otherwise.
   */
  public function has($type);

  /**
   * Retrieve the model of the given type.
   *
   * @param string $type
   *   The type.
   *
   * @return \Tozart\Model\ModelInterface|false
   *   A model instance. FALSE if no model
   *   for the given type could be loaded.
   */
  public function get($type);

}
