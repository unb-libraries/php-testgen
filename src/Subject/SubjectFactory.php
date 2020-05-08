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
   * Array of model definitions that this factory can create.
   *
   * @var SubjectModel[]
   */
  protected $models = [];

  /**
   * Create a ModelFactory instance.
   *
   * @param SubjectModel[] $models
   *   Array of model definitions this factory should build.
   */
  public function __construct($models = []) {
    $this->addModels($models);
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
   * Add multiple model definitions.
   *
   * @param SubjectModel[] $models
   *   An array of model definitions to add.
   */
  public function addModels(array $models) {
    foreach ($models as $definition) {
      $this->addModel($definition);
    }
  }

  /**
   * Add a single model definition.
   *
   * @param SubjectModel $definition
   *   The model definition to add.
   */
  public function addModel(SubjectModel $definition) {
    $definitions = $this->models;
    if (!array_key_exists($definition->getType(), $definitions)) {
      $this->models[$definition->getType()] = $definition;
    }
  }

  /**
   * Retrieve all types and definitions for models this factory can build.
   *
   * @return SubjectModel[]
   *   Array of model definitions.
   */
  public function getModels() {
    return $this->models;
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
    $definitions = $this->getModels();
    if (array_key_exists($type, $definitions)) {
      return $definitions[$type];
    }
    return NULL;
  }

}
