<?php

namespace TestGen\model;

use TestGen\os\ParsableFile;

/**
 * Factory to build models from model definitions.
 *
 * @package TestGen\model
 */
class ModelFactory {

  /**
   * Array of model definitions that this factory can create.
   *
   * @var ModelDefinition[]
   */
  protected $modelDefinitions = [];

  /**
   * Create a ModelFactory instance.
   *
   * @param ModelDefinition[] $definitions
   *   Array of model definitions this factory should build.
   */
  public function __construct($definitions = []) {
    $this->addDefinitions($definitions);
  }

  /**
   * Create a model of the given type.
   *
   * @param ParsableFile $file
   *   A parsable file containing a description
   *   of the model to create.
   *
   * @return mixed|false
   *   An instance of the created model.
   *   FALSE if no model could be created for the given type.
   */
  public function createFromFile(ParsableFile $file) {
    $model_description = $file->parse();
    if ($model_description && array_key_exists('id', $model_description) && array_key_exists('type', $model_description)) {
      $definition = $this->getDefinition($model_description['type']);
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
        return new $class($model_description['id'], $properties);
      }
    }
    return FALSE;
  }

  /**
   * Add multiple model definitions.
   *
   * @param ModelDefinition[] $definitions
   *   An array of model definitions to add.
   */
  public function addDefinitions(array $definitions) {
    foreach ($definitions as $definition) {
      $this->addDefinition($definition);
    }
  }

  /**
   * Add a single model definition.
   *
   * @param ModelDefinition $definition
   *   The model definition to add.
   */
  public function addDefinition(ModelDefinition $definition) {
    $definitions = $this->modelDefinitions;
    if (!array_key_exists($definition->getType(), $definitions)) {
      $this->modelDefinitions[$definition->getType()] = $definition;
    }
  }

  /**
   * Retrieve all types and definitions for models this factory can build.
   *
   * @return ModelDefinition[]
   *   Array of model definitions.
   */
  public function getDefinitions() {
    return $this->modelDefinitions;
  }

  /**
   * Retrieve the model with the given type.
   *
   * @param string $type
   *   The model type.
   *
   * @return ModelDefinition|null
   *   A model definition, if one exists for the given type.
   *   NULL if no definition could be found.
   */
  public function getDefinition($type) {
    $definitions = $this->getDefinitions();
    if (array_key_exists($type, $definitions)) {
      return $definitions[$type];
    }
    return NULL;
  }

}
