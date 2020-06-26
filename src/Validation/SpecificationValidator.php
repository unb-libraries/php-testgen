<?php

namespace Tozart\Validation;

/**
 * Validator for specification files.
 *
 * @package Tozart\Validation
 */
abstract class SpecificationValidator extends FileFormatValidator {

  /**
   * {@inheritDoc}
   */
  public function validate($object) {
    if (empty($errors = parent::validate($object))) {
      $model_description = $object->parse();
      $properties = [
        'essential' => [
          'properties' => $this->optionalProperties($model_description),
          'required' => TRUE,
        ],
        'required' => [
          'properties' => $this->requiredProperties($model_description),
          'required' => TRUE,
        ],
        'optional' => [
          'properties' => $this->optionalProperties($model_description),
          'required' => FALSE,
        ],
      ];

      // TODO: Validate conditionally required properties, e.g. at least one out of required/optional must be present.
      foreach ($properties as $validation_description) {
        if (empty($errors)) {
          $errors += $this->validateProperties($validation_description['properties'], $model_description, $validation_description['required']);
        }
      }
    }
    return $errors;
  }

  /**
   * Define any properties that must be present to even validate the remains of the specification.
   *
   * @param array $specification
   *   The specification to be validated.
   *
   * @return array
   *   A one-dimensional array of string.
   */
  abstract protected function essentialProperties(array $specification);

  /**
   * Define any required properties that must be present in order for validation to be successful.
   *
   * @param array $specification
   *   The specification to be validated.
   *
   * @return array
   *   A one-dimensional array of string.
   */
  abstract protected function requiredProperties(array $specification);

  /**
   * Define any required properties that are not required, but should be validated if present.
   *
   * @param array $specification
   *   The specification to be validated.
   *
   * @return array
   *   A one-dimensional array of string.
   */
  abstract protected function optionalProperties(array $specification);

  /**
   * Validate each of the given properties.
   *
   * @param array $properties
   *   The properties to validate.
   * @param array $specification
   *   The entire specification.
   * @param bool $required
   *   Whether the given properties are required.
   *
   * @see \Tozart\Validation\SpecificationValidator::validateProperty().
   *
   * @return array
   *   An array of errors, if any occur, keyed by the property which caused the error.
   *   An empty array if all properties were validated successfully.
   */
  protected function validateProperties(array $properties, array $specification, $required = TRUE) {
    $errors = [];
    foreach ($properties as $property) {
      if (!empty($property_errors = $this->validateProperty($property, $specification, $required))) {
        $errors[$property] = $property_errors;
      }
    }
    return $errors;
  }

  /**
   * Validate the given property.
   *
   * @param string $property
   *   The property
   * @param array $specification
   *   The entire specification.
   * @param bool $required
   *   Whether the property is required or optional. Required
   *   properties will be validated for existence. Optional
   *   properties will only be validated IF they exist.
   *
   * @return array
   *   An array of errors, if any occur. An empty array if the
   *   property was successfully validated.
   */
  protected function validateProperty($property, $specification, $required = TRUE) {
    $errors = [];
    if ($required && !$this->hasProperty($property, $specification)) {
      $errors[] = "A {$property} property must be defined.";
    }
    elseif ($this->hasProperty($property, $specification) && is_callable($callback = $this->getPropertyCallback($property))) {
      $errors = call_user_func($callback, $specification[$property], $property, $specification);
    }
    return $errors;
  }

  /**
   * Whether the given property is part of the given specification.
   *
   * @param string $property
   *   The property identifier.
   * @param array $specification
   *   The entire specification.
   *
   * @return bool
   *   TRUE if the given property exists in the given
   *   specification. FALSE otherwise.
   */
  protected function hasProperty($property, $specification) {
    return array_key_exists($property, $specification);
  }

  /**
   * Build a property callback for custom validation of the given property.
   *
   * @param string $property
   *   The property Identifier.
   *
   * @return array
   *   A callable array. The method name will be "validateTheProperty"
   *   if the property identifier is "the_property".
   */
  private function getPropertyCallback($property) {
    $upper_camel_case_property = implode('', array_map(function ($string) {
      return ucfirst($string);
    }, explode('_', $property)));
    $callback_name = 'validate' . $upper_camel_case_property;
    return [$this, $callback_name];
  }

}
