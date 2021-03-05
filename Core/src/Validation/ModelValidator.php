<?php

namespace Trupal\Core\Validation;

use Trupal\Model\Model;
use Trupal\Model\ModelInterface;
use Trupal\Subject\SubjectInterface;

/**
 * Validator for model specifications.
 *
 * @package Trupal\Validation
 */
class ModelValidator extends SpecificationValidator {

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'model';
  }

  /**
   * {@inheritDoc}
   */
  protected function defaultSpecification() {
    return [
      'type' => '',
      'class' => Model::class,
      'subject_class' => '',
      'requirements' => [],
      'options' => [],
    ];
  }

  /**
   * Validation callback for the "type" property.
   *
   * @param mixed $type
   *   The type value.
   * @param string $property
   *   The property identifier.
   * @param array $specification
   *   The entire specification.
   *
   * @return bool
   *   TRUE if the property is a non-empty string.
   *   FALSE otherwise.
   */
  protected function validateType($type, string $property, array $specification) {
    return !empty($type) && is_string($type);
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
   * @return bool
   *   TRUE if the property points to an existing
   *   class that implements the ModelInterface.
   *   FALSE otherwise.
   */
  protected function validateClass($class, string $property, array $specification) {
    if (!class_exists($class)) {
      // TODO: Log property set to non-existing class.
      return FALSE;
    }

    if (!in_array(ModelInterface::class, class_implements($class))) {
      // TODO: Log property set to class not implementing the SubjectInterface.
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Validation callback for the "subject_class" property.
   *
   * @param mixed $class
   *   The class value.
   * @param string $property
   *   The property identifier.
   * @param array $specification
   *   The entire specification.
   *
   * @return bool
   *   TRUE if the property points to an existing
   *   class that implements the SubjectInterface.
   *   FALSE otherwise.
   */
  protected function validateSubjectClass($class, string $property, array $specification) {
    if (!class_exists($class)) {
      // TODO: Log property set to non-existing class.
      return FALSE;
    }

    if (!in_array(SubjectInterface::class, class_implements($class))) {
      // TODO: Log property set to class not implementing the SubjectInterface.
      return FALSE;
    }
    return TRUE;
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
   * @return bool
   *   TRUE if property is an array.
   *
   * @see \Trupal\Validation\SpecificationValidator::validateProperty().
   */
  protected function validateRequirements($requirements, string $property, array $specification) {
    if (!is_array($requirements)) {
      // TODO: Log property set to a value that's not an array.
      return FALSE;
    }
    return TRUE;
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
   * @return bool
   *   TRUE if property is an array where
   *   each property is assigned a default
   *   value.
   *
   * @see \Trupal\Validation\SpecificationValidator::validateProperty().
   */
  protected function validateOptions($options, string $property, array $specification) {
    if (!is_array($options)) {
      // TODO: Log property set to a value that's not an array.
      return FALSE;
    }

    foreach ($options as $key => $default_value) {
      if (is_numeric($key) || empty($default_value)) {
        // TODO: Log property not defining a default value.
        return FALSE;
      }
    }

    return TRUE;
  }

}
