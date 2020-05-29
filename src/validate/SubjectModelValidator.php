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
    return $errors;
  }

}
