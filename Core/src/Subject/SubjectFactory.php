<?php

namespace Trupal\Subject;

use Trupal\Discovery\DiscoveryInterface;
use Trupal\Discovery\FactoryBase;
use Trupal\Model\ModelManagerInterface;

/**
 * Factory to build models from model definitions.
 *
 * @package Trupal\model
 */
class SubjectFactory extends FactoryBase {

  // TODO: Refactor SubjectFactory. Get rid of FactoryBase.

  /**
   * The model manager.
   *
   * @var \Trupal\Model\ModelManagerInterface
   */
  protected $_modelManager;

  /**
   * The model manager.
   *
   * @return \Trupal\Model\ModelManagerInterface
   *   A model manager instance.
   */
  protected function modelManager() {
    return $this->_modelManager;
  }

  /**
   * Create a new subject factory instance.
   *
   * @param \Trupal\Discovery\DiscoveryInterface $discovery
   *   A discovery service instance.
   * @param \Trupal\Model\ModelManagerInterface $model_manager
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
   * @return \Trupal\Subject\SubjectInterface
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
