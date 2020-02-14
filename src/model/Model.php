<?php

namespace TestGen\model;

use Symfony\Component\Yaml\Yaml;
use TestGen\os\File;

/**
 * Class Model.
 *
 * @package TestGen\model
 */
class Model {

  /**
   * The model ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The model type.
   *
   * @var string
   */
  protected $type;

  /**
   * Retrieve the model ID.
   *
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Retrieve the model type.
   *
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Create a new model instance.
   *
   * @param string $id
   *   The model ID.
   * @param string $type
   *   The model type.
   */
  public function __construct($id = '', $type = '') {
    // TODO: Do NOT accept empty ID and type.
    $this->id = $id;
    $this->type = $type;
  }

  /**
   * Create a model instance from parsing a YAML file.
   *
   * @param File $model_definition
   *   The file containing the model definition.
   *
   * @return Model|null
   *   The created model instance.
   *   NULL if no model could be created from the given file.
   */
  public static function createFromFile(File $model_definition) {
    try {
      $yaml = Yaml::parse($model_definition->content());
      return new Model(
          $yaml['id'],
          $yaml['type']
      );
    }
    catch (\Exception $e) {
      return NULL;
    }
  }

}
