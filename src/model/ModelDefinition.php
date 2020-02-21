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
      if (count(array_intersect(['type', 'class', 'requirements', 'options'], array_keys($parsed_file))) === 4) {
        return new static(
          $parsed_file['type'],
          $parsed_file['class'],
          $parsed_file['requirements'],
          $parsed_file['options']
        );
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
