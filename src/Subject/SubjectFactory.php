<?php

namespace Tozart\Subject;

use Tozart\Discovery\FactoryInterface;
use Tozart\Model\ModelManagerInterface;

/**
 * Factory to build models from model definitions.
 *
 * @package Tozart\model
 */
class SubjectFactory implements FactoryInterface {

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
   * @param \Tozart\Model\ModelManagerInterface $model_manager
   */
  public function __construct(ModelManagerInterface $model_manager) {
    $this->_modelManager = $model_manager;
  }

  /**
   * {@inheritDoc}
   */
  public function create(array $specification) {
    if ($model = $this->modelManager()->get($specification['type'])) {
      $class = $model->getSubjectClass();
      $specification += $model->getOptions();
      return new $class($model, $specification);
    }
    return FALSE;
  }

}
