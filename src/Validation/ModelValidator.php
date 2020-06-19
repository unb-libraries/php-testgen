<?php

namespace Tozart\Validation;

use Tozart\Model\ModelInterface;

class ModelValidator extends FileFormatValidator {

  public function validate($object) {
    if (empty($errors = parent::validate($object))) {
      $model_description = $object->parse();
      // TODO: Validate conditionally required properties, e.g. at least one out of required/optional must be present.
      $errors = $this->validateRequiredProperties($model_description);
      if (empty($errors)) {
        $errors += $this->validateOptionalProperties($model_description);
      }
    }
    return $errors;
  }

  protected function validateRequiredProperties($model_description) {
    $errors = [];
    foreach ($this->requiredProperties() as $property) {
      if (!empty($property_errors = $this->validateProperty($property, $model_description))) {
        $errors[$property] = $property_errors;
      }
    }
    return $errors;
  }

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

  protected function validateOptionalProperties($model_description) {
    $errors = [];
    foreach ($this->optionalProperties() as $property) {
      if (!empty($property_errors = $this->validateProperty($property, $model_description, FALSE))) {
        $errors[$property] = $property_errors;
      }
    }
    return $errors;
  }

  protected function optionalProperties() {
    return [
      'requirements',
      'options',
    ];
  }

  protected function validateProperty($property, $model_description, $required = TRUE) {
    $errors = [];
    if ($required && !$this->hasProperty($property, $model_description)) {
      $errors[] = "A {$property} property must be defined.";
    }
    elseif ($this->hasProperty($property, $model_description) && is_callable($callback = $this->getPropertyCallback($property))) {
      $errors = call_user_func($callback, $model_description[$property], $property, $model_description);
    }
    return $errors;
  }

  protected function hasProperty($property, $model_description) {
    return array_key_exists($property, $model_description);
  }

  private function getPropertyCallback($property) {
    $upper_camel_case_property = implode('', array_map(function ($string) {
      return ucfirst($string);
    }, explode('_', $property)));
    $callback_name = 'validate' . $upper_camel_case_property;
    return [$this, $callback_name];
  }

  protected function validateClass($value, $property, array $model_description) {
    $errors = [];
    if (!class_exists($value)) {
      $errors[] = "'{$value}' does not exist.";
    }
    elseif (!in_array(ModelInterface::class, class_implements($value))) {
      $errors[] = "{$value} must implement " . ModelInterface::class;
    }
    return $errors;
  }

  protected function validateRequirements($value, $property, array $model_description) {
    $errors = [];
    if (!is_array($value)) {
      $errors[] = "{$property} must be of type \"array\"";
    }
    elseif (empty($value)) {
      $errors[] = "{$property} must not be empty.";
    }
    return $errors;
  }

  protected function validateOptions($value, $property, array $model_description) {
    $errors = [];
    if (!is_array($value)) {
      $errors[] = "{$property} must be of type \"array\"";
    }
    else {
      foreach ($value as $key => $default_value) {
        if (is_numeric($key) || empty($default_value)) {
          $errors[] = "{$property} must define a default value.";
        }
      }
    }
    return $errors;
  }

}
