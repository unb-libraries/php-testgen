<?php

namespace Tozart\Test\Validation;

use Tozart\Validation\SpecificationValidator;

/**
 * Testable extension of abstract SpecificationValidator.
 *
 * @package Tozart\Test\Validation
 */
class TestableSpecificationValidator extends SpecificationValidator {

  /**
   * {@inheritDoc}
   */
  protected function defaultSpecification() {
    return [
      'requiredProperty' => '',
      'optionalProperty' => '',
    ];
  }

  /**
   * Validate the "requiredProperty" property.
   *
   * @param mixed $value
   *   The value of the property.
   * @param string $property
   *   The name of the property.
   * @param array $specification
   *   The complete specification.
   *
   * @return bool
   *   TRUE if a property value is provided.
   */
  protected function validateRequiredProperty($value, string $property, array $specification) {
    return !empty($value);
  }

  /**
   * Validate the "optionalProperty" property.
   *
   * @param mixed $value
   *   The value of the property.
   * @param string $property
   *   The name of the property.
   * @param array $specification
   *   The complete specification.
   *
   * @return bool
   *   TRUE if the property value is either a string
   *   or no value is provided at all.
   */
  protected function validateOptionalProperty($value, string $property, array $specification) {
    return empty($value) || is_string($value);
  }

}
