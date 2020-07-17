<?php

namespace Tozart\Model;

use Tozart\Discovery\FactoryInterface;

/**
 * Class to maintain model instances.
 *
 * @package Tozart\Model
 */
class ModelManager implements ModelManagerInterface {

  /**
   * The models.
   *
   * @var \Tozart\Model\ModelInterface[]
   */
  protected $_models = [];

  /**
   * The model factory service.
   *
   * @var \Tozart\Discovery\FactoryInterface
   */
  protected $_factory;

  /**
   * {@inheritDoc}
   */
  public function models() {
    return $this->_models;
  }

  /**
   * Retrieve the model factory service.
   *
   * @return \Tozart\Discovery\FactoryInterface
   *   A model factory instance.
   */
  protected function factory() {
    return $this->_factory;
  }

  /**
   * Create a new model manager instance.
   *
   * @param \Tozart\Discovery\FactoryInterface $factory
   *   The model factory service.
   */
  public function __construct(FactoryInterface $factory) {
    $this->_factory = $factory;
  }

  /**
   * {@inheritDoc}
   */
  public function get($type) {
    if (!$this->has($type)) {
      if (!$model = $this->factory()->create($type)) {
        return FALSE;
      }
      $this->add($model);
    }
    return $this->models()[$type];
  }

  /**
   * {@inheritDoc}
   */
  public function has($type) {
    return array_key_exists($type, $this->models());
  }

  /**
   * Add (or replace) the given model.
   *
   * @param \Tozart\Model\ModelInterface $model
   *   A model instance.
   * @param bool $replace
   *   Whether an existing model should be replaced.
   */
  protected function add(ModelInterface $model, $replace = TRUE) {
    if ($replace || !$this->has($model->getType())) {
      $this->_models[$model->getType()] = $model;
    }
  }

}
