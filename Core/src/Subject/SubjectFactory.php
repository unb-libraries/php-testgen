<?php

namespace Trupal\Core\Subject;

use Trupal\Core\Discovery\DiscoveryInterface;
use Trupal\Core\Discovery\FactoryBase;
use Trupal\Core\Model\ModelManagerInterface;

/**
 * Factory to build models from model definitions.
 *
 * @package Trupal\Core\model
 */
class SubjectFactory extends FactoryBase {

  // TODO: Refactor SubjectFactory. Get rid of FactoryBase.

  /**
   * The model manager.
   *
   * @var \Trupal\Core\Model\ModelManagerInterface
   */
  protected $_modelManager;

  /**
   * The model manager.
   *
   * @return \Trupal\Core\Model\ModelManagerInterface
   *   A model manager instance.
   */
  protected function modelManager() {
    return $this->_modelManager;
  }

  /**
   * Create a new subject factory instance.
   *
   * @param \Trupal\Core\Discovery\DiscoveryInterface $discovery
   *   A discovery service instance.
   * @param \Trupal\Core\Model\ModelManagerInterface $model_manager
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
   * @return \Trupal\Core\Subject\SubjectInterface
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
