<?php

namespace TestGen\model;

use TestGen\os\ParsableFile;

class ModelDefinition {

  protected $id;
  protected $modelClass;

  public static function createFromFile(ParsableFile $model_definition_file) {
    if ($parsed_file = $model_definition_file->parse()) {
      if ($id = $parsed_file['id'] && $model_class = $parsed_file['model_class']) {
        return new static($id, $model_class);
      }
    }
    return NULL;
  }

  public function __construct($id, $model_class) {
    $this->id = $id;
    $this->modelClass = $model_class;
  }

  public function getId() {
    return $this->id;
  }

  public function getModelClass() {
    return $this->modelClass;
  }

}
