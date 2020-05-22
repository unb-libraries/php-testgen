<?php

namespace Tozart\Subject;

use Tozart\os\File;
use Tozart\os\ParsableFile;

/**
 * Factory to build models from model definitions.
 *
 * @package Tozart\model
 */
class SubjectFactory {

  /**
   * @var \Tozart\os\Locator
   */
  protected $_modelLocator;

  /**
   * @var \Tozart\Subject\SubjectModel[]
   */
  protected $_models;

  protected function modelLocator() {
    return $this->_modelLocator;
  }

  public function getModels() {
    if (!isset($this->_models)) {
      $this->_models = [];
      $this->discover();
    }
    return $this->_models;
  }

  /**
   * Create a ModelFactory instance.
   *
   * @param array $model_roots
   *   Array of model definitions this factory should build.
   */
  public function __construct(array $model_roots = []) {
    $this->_modelLocator = new SubjectModelLocator($model_roots);
  }

  public function discover() {
    $options = [
      'flatten' => TRUE,
      'return_as_object' => TRUE,
    ];
    foreach ($this->modelLocator()->find($options) as $filename => $file) {
      $model = SubjectModel::createFromFile($file);
      if (!array_key_exists($type = $model->getType(), $this->_models)) {
        $this->_models[$type] = $model;
      }
    }
  }

  /**
   * Create a model of the given type.
   *
   * @param \Tozart\os\File $file
   *   A parsable file containing a description
   *   of the model to create.
   *
   * @return mixed|false
   *   An instance of the created model.
   *   FALSE if no model could be created for the given type.
   */
  public function createFromFile(File $file) {
    if (!$model_description = $this->parse($file)) {
      return NULL;
    }

    if (array_key_exists('id', $model_description) && array_key_exists('type', $model_description)) {
      $definition = $this->getModel($model_description['type']);
      if ($definition && ($class = $definition->getModelClass())) {
        $requirements = [];
        foreach ($definition->getRequirements() as $property) {
          if (array_key_exists($property, $model_description)) {
            $requirements[$property] = $model_description[$property];
          }
          else {
            return FALSE;
          }
        }
        $options = array_intersect_key($model_description, $definition->getOptions());
        $properties = array_merge($requirements, $options);
        return new $class($model_description['id'], $definition, $properties);
      }
    }
    return FALSE;
  }

  protected function parse($file) {
    try {
      return $file->parse();
    }
    catch (\Exception $e) {
      return NULL;
    }
  }

  /**
   * Retrieve the model with the given type.
   *
   * @param string $type
   *   The model type.
   *
   * @return SubjectModel|null
   *   A model definition, if one exists for the given type.
   *   NULL if no definition could be found.
   */
  public function getModel($type) {
    if (array_key_exists($type, $models = $this->getModels())) {
      return $models[$type];
    }
    return NULL;
  }

}
