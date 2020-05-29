<?php

namespace Tozart\validate;

use Tozart\os\File;

class SubjectModelValidator extends FileFormatValidator {

  /**
   * Retrieve all required properties.
   *
   * @return array
   *   An array of strings.
   */
  protected function requiredProperties() {
    return [
      'type',
      'class',
    ];
  }

  public function validate($object) {
    if (empty($errors = parent::validate($object))) {
      $model_description = $this->parser($this->fileType())->parse($object);
      $errors = $this->validateProperties($model_description);
    }
    return $errors;
  }

  protected function validateProperties($model_description) {
    $errors = [];
    foreach ($this->requiredProperties() as $property) {
      $errors = array_merge(
        $errors, $this->validateProperty($property, $model_description));
    }
    return $errors;
  }

  protected function validateProperty($property, $model_description) {
    $errors = [];
    if (!$this->hasProperty($property, $model_description)) {
      // TODO: Translate error messages.
      $errors[] = "The model must define a '{$property}'.";
    }
    else {
      $method_name = 'validate' . ucfirst($property);
      if (method_exists($this, $method_name)) {
        $errors = array_merge($errors,
          call_user_func([$this, $method_name], $model_description[$property]));
      }
    }
    return $errors;
  }

  protected function hasProperty($property, $model_description) {
    return array_key_exists($property, $model_description);
  }

  protected function validateClass($class) {
    if (!class_exists($class)) {
      return [
        "'{$class}' is not a valid class."
      ];
    }
  }

}
