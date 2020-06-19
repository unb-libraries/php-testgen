<?php

namespace Tozart\Model;

use Tozart\Discovery\DiscoveryInterface;

/**
 * Factory for creating model instances.
 *
 * @package Tozart\Model
 */
class ModelFactory {

  /**
   * A discovery service instance.
   *
   * @var \Tozart\Discovery\DiscoveryInterface
   */
  protected $_discovery;

  /**
   * Retrieve the discovery service.
   *
   * @return \Tozart\Discovery\DiscoveryInterface
   *   A discovery object.
   */
  public function discovery() {
    return $this->_discovery;
  }

  /**
   * Construct a new ModelFactory instance.
   *
   * @param \Tozart\Discovery\DiscoveryInterface $discovery
   *   A discovery service instance.
   */
  public function __construct(DiscoveryInterface $discovery) {
    $this->_discovery = $discovery;
  }

  /**
   * Create a new model instance.
   *
   * @param string $type
   *   A string.
   *
   * @return \Tozart\Model\ModelInterface|false
   *   A model instance. FALSE if a model of the
   *   given type could not be created.
   */
  public function create($type) {
    if ($specification = $this->findSpecification($type)) {
      return $this->doCreate($specification);
    }
    return FALSE;
  }

  /**
   * Find a model specification for the given type.
   *
   * @param string $type
   *   A string.
   *
   * @return array|false
   *   A specification array. FALSE if no specification
   *   exists for the given type.
   */
  protected function findSpecification($type) {
    foreach ($this->discovery()->discover() as $dir => $files) {
      foreach ($files as $file_path => $file) {
        /** @var \Tozart\os\File $file */
        $model_specification = $file->parse();
        if ($model_specification['type'] === $type) {
          return $model_specification;
        }
      }
    }
    return FALSE;
  }

  /**
   * Actually build the model.
   *
   * @param array $specification
   *   A model specification.
   *
   * @return \Tozart\Model\ModelInterface
   *   A model instance.
   */
  protected function doCreate(array $specification) {
    $class = $specification['class'];
    $constructor = [$class, 'create'];
    return call_user_func($constructor, $specification);
  }

}