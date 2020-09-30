<?php

namespace Tozart\Validation;

use Tozart\Discovery\Filter\ModelValidationFilter;

/**
 * Factory to build validators of different types.
 *
 * @package Tozart\Validation
 */
class ValidatorFactory implements ValidatorFactoryInterface {

  /**
   * {@inheritDoc}
   */
  public function create($type, array $configuration) {
    if ($specification = $this->getSpecification($type)) {
      $class = $specification['class'];
      return new $class($configuration);
    }
    throw new \Exception("A validator of type \"{$type}\" could not be created.");
  }

  /**
   * Retrieve the specification for a validator of the given type.
   *
   * @param string $type
   *   A string.
   *
   * @return string|null
   *   An array specifying a validator.
   */
  protected function getSpecification($type) {
    $specifications = $this->getSpecifications();
    return array_key_exists($type, $specifications)
      ? $specifications[$type]
      : NULL;
  }

  /**
   * Retrieve the mapping between validator types and their classes.
   *
   * @return array
   *   An array assigning a fully qualified class name to each validator type.
   */
  public function getSpecifications() {
    $specifications = [];
    foreach ($this->getValidatorClasses() as $class) {
      $interface = $this->getValidatorInterface();
      if ($class instanceof $interface) {
        $id = call_user_func($class, 'getId');
        $specification = call_user_func($class, 'getSpecification') + [
          'id' => $id,
          'class' => $class,
        ];
        $specifications[$id] = $specification;
      }
    }

    return $specifications;
  }

  /**
   * Retrieve an array of validator class names.
   *
   * @return string[]
   *   An array of fully qualified validator class names.
   */
  protected function getValidatorClasses() {
    return [
      FileFormatValidator::class,
      ModelValidationFilter::class,
      SpecificationValidator::class,
      SubjectValidator::class,
    ];
  }

  /**
   * Retrieve the interface which validators must implement.
   * @return string
   */
  protected function getValidatorInterface() {
    return ValidatorInterface::class;
  }

}
