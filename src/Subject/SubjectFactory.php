<?php

namespace Tozart\Subject;

use Tozart\Discovery\DiscoveryInterface;
use Tozart\Discovery\FactoryBase;
use Tozart\Model\ModelManagerInterface;

/**
 * Factory to build models from model definitions.
 *
 * @package Tozart\model
 */
class SubjectFactory extends FactoryBase {

  // TODO: Refactor SubjectFactory. Get rid of FactoryBase.

  /**
   * The model manager.
   *
   * @var \Tozart\Model\ModelManagerInterface
   */
  protected $_modelManager;

  /**
   * The model manager.
   *
   * @return \Tozart\Model\ModelManagerInterface
   *   A model manager instance.
   */
  protected function modelManager() {
    return $this->_modelManager;
  }

  /**
   * Create a new subject factory instance.
   *
   * @param \Tozart\Discovery\DiscoveryInterface $discovery
   *   A discovery service instance.
   * @param \Tozart\Model\ModelManagerInterface $model_manager
   *   A model manager service instance.
   */
  public function __construct(DiscoveryInterface $discovery, ModelManagerInterface $model_manager) {
    parent::__construct($discovery);
    $this->_modelManager = $model_manager;
  }

  /**
   * Create a subject object from the given specification.
   *
   * @param array $specification
   *   The specification.
   *
   * @return \Tozart\Subject\SubjectInterface
   *   A subject object.
   */
  public function createFromSpecification(array $specification) {
    return $this->doCreate($specification);
  }

  /**
   * {@inheritDoc}
   */
  protected function findSpecification($key) {
    return FALSE;
  }

  /**
   * {@inheritDoc}
   */
  protected function doCreate($specification) {
    if ($model = $this->modelManager()->get($specification['type'])) {
      $class = $model->getSubjectClass();
      $specification += $model->getOptions();
      return new $class($model, $specification);
    }
    return FALSE;
  }

}
