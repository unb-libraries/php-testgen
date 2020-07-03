<?php

namespace Tozart\Validation;

use Tozart\Model\ModelInterface;
use Tozart\Subject\SubjectInterface;

/**
 * Validator for model specifications.
 *
 * @package Tozart\Validation
 */
class ModelValidator extends SpecificationValidator {

  /**
   * {@inheritDoc}
   */
  protected function essentialProperties(array $specification) {
    return [
      'type',
      'class',
    ];
  }

  /**
   * {@inheritDoc}
   */
  protected function requiredProperties(array $specification) {
    return [];
  }

  /**
   * {@inheritDoc}
   */
  protected function optionalProperties(array $specification) {
    return [
      'requirements',
      'options',
    ];
  }

  /**
   * Validation callback for the "class" property.
   *
   * @param mixed $class
   *   The class value.
   * @param string $property
   *   The property identifier.
   * @param array $specification
   *   The entire specification.
   *
   * @return array
   *   An array of error message strings.
   *
   * @see \Tozart\Validation\SpecificationValidator::validateProperty().
   */
  protected function validateClass($class, $property, array $specification) {
    $errors = [];
    if (!class_exists($class)) {
      $errors[] = "'{$class}' does not exist.";
    }
    elseif (!in_array(SubjectInterface::class, class_implements($class))) {
      $errors[] = "{$class} must implement " . SubjectInterface::class;
    }
    return $errors;
  }

  /**
   * Validation callback for the "requirements" property.
   *
   * @param mixed $requirements
   *   An array of required properties (strings).
   * @param string $property
   *   The property identifier.
   * @param array $specification
   *   The entire specification.
   *
   * @return array
   *   An array of error message strings.
   *
   * @see \Tozart\Validation\SpecificationValidator::validateProperty().
   */
  protected function validateRequirements($requirements, $property, array $specification) {
    $errors = [];
    if (!is_array($requirements)) {
      $errors[] = "{$property} must be of type \"array\"";
    }
    elseif (empty($requirements)) {
      $errors[] = "{$property} must not be empty.";
    }
    return $errors;
  }

  /**
   * Validation callback for the "options" property.
   *
   * @param mixed $options
   *   An array of optional properties (strings) and
   *   their default values.
   * @param string $property
   *   The property identifier.
   * @param array $specification
   *   The entire specification.
   *
   * @return array
   *   An array of error message strings.
   *
   * @see \Tozart\Validation\SpecificationValidator::validateProperty().
   */
  protected function validateOptions($options, $property, array $specification) {
    $errors = [];
    if (!is_array($options)) {
      $errors[] = "{$property} must be of type \"array\"";
    }
    else {
      foreach ($options as $key => $default_value) {
        if (is_numeric($key) || empty($default_value)) {
          $errors[] = "{$property} must define a default value.";
        }
      }
    }
    return $errors;
  }

}
