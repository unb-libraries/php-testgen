<?php

namespace TestGen\model;

use TestGen\os\ParsableFile;

class ModelDefinition {

  protected $type;
  protected $modelClass;
  protected $requirements;
  protected $options;

  public static function createFromFile(ParsableFile $model_definition_file) {
    if ($parsed_file = $model_definition_file->parse()) {
      if ($id = $parsed_file['id']
          && $model_class = $parsed_file['model_class']
          && $requirements = $parsed_file['requirements']
          && $options = $parsed_file['options']) {
        return new static($id, $model_class);
      }
    }
    return NULL;
  }

  public function __construct($type, $model_class, $requirements = [], $options = []) {
    $this->type = $type;
    $this->modelClass = $model_class;
    $this->requirements = $requirements;
    $this->options = $options;
  }

  public function getType() {
    return $this->type;
  }

  public function getModelClass() {
    return $this->modelClass;
  }

  public function getRequirements() {
    return $this->requirements;
  }

  public function getOptions() {
    return $this->options;
  }

  public function getProperties() {
    return array_merge(
        array_values($this->getRequirements()),
        array_keys($this->getOptions())
    );
  }

}
