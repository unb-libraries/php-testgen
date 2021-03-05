<?php

namespace Trupal\Test\Validation;

use Trupal\Model\Model;

/**
 * Model to verify subject validation.
 *
 * @package Trupal\Validation
 */
class SubjectValidationTestModel extends Model {

  /**
   * Validate the "requiredProperty" property value of a subject.
   *
   * @param mixed $value
   *   The value of the property.
   * @param string $property
   *   The name of the property.
   * @param array $specification
   *   The complete specification.
   *
   * @return bool
   *   TRUE if the value equals "someValue". FALSE otherwise.
   */
  public function validateRequiredProperty($value, string $property, array &$specification) {
    return $value === 'someValue';
  }

  /**
   * Validate the "optionalProperty" property value of a subject.
   *
   * @param mixed $value
   *   The value of the property.
   * @param string $property
   *   The name of the property.
   * @param array $specification
   *   The complete specification.
   *
   * @return bool
   *   TRUE if the value is greater than 0. FALSE otherwise.
   */
  public function validateOptionalProperty($value, string $property, array &$specification) {
    return $value > 0;
  }

}
