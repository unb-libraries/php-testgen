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
      return call_user_func([$class, 'create'], $specification);
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
  protected function getSpecification(string $type) {
    $specifications = $this->getSpecifications();
    return array_key_exists($type, $specifications)
      ? $specifications[$type]
      : NULL;
  }

  /**
   * {@inheritDoc}
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
      ModelValidator::class,
      SpecificationValidator::class,
      SubjectValidator::class,
    ];
  }

  /**
   * Retrieve the interface which validators must implement.
   *
   * @return string
   *   A fully qualified interface name.
   */
  protected function getValidatorInterface() {
    return ValidatorInterface::class;
  }

}
