<?php

namespace Tozart\Model;

use Tozart\Discovery\DiscoveryInterface;
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
   * The model discovery service.
   *
   * @var \Tozart\Discovery\DiscoveryInterface
   */
  protected $_discovery;

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
   * Retrieve the model discovery service.
   *
   * @return \Tozart\Discovery\DiscoveryInterface
   *   A discovery instance.
   */
  protected function discovery() {
    return $this->_discovery;
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
   * @param \Tozart\Discovery\DiscoveryInterface $discovery
   *   The model discovery service.
   */
  public function __construct(FactoryInterface $factory, DiscoveryInterface $discovery) {
    $this->_factory = $factory;
    $this->_discovery = $discovery;
    $this->loadModels();
  }

  /**
   * Populate the collection of models.
   */
  protected function loadModels() {
    foreach ($this->discovery()->discover() as $dir => $files) {
      foreach ($files as $filename => $file) {
        /** @var \Tozart\os\File $file */
        $specification = $file->parse();
        if ($model = $this->factory()->create($specification['type'])) {
          $this->add($model, FALSE);
        }
      }
    }
  }

  /**
   * {@inheritDoc}
   */
  public function get($type) {
    if ($this->has($type)) {
      return $this->models()[$type];
    }
    return FALSE;
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
