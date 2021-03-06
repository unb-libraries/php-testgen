<?php

namespace Trupal\Core\Validation;

/**
 * Factory to build validators of different types.
 *
 * @package Trupal\Core\Validation
 */
class ValidatorFactory implements ValidatorFactoryInterface {

  /**
   * The names of all classes this factory supports.
   *
   * @var array
   */
  protected $_classes;

  /**
   * Retrieve the names of all classes this factory supports.
   *
   * @return string[]
   *   An array of fully qualified validator class names.
   */
  protected function getTargetClasses() {
    return $this->_classes;
  }

  /**
   * Create a new ValidatorFactory object.
   *
   * @param array $classes
   *   An array of classes which the factory supports.
   */
  public function __construct(array $classes) {
    $this->_classes = $classes;
  }

  /**
   * {@inheritDoc}
   */
  public function create(string $type, array $configuration) {
    if ($specification = $this->getSpecification($type)) {
      $class = $specification['class'];
      return call_user_func([$class, 'create'], $configuration);
    }
    // TODO: Log the failed creation of a validator.
    return NULL;
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
    foreach ($this->getTargetClasses() as $class) {
      if (!empty($id = $this->tryGetId($class)) && is_array($specification = $this->tryGetSpecification($class))) {
        $specification += [
          'id' => $id,
          'class' => $class,
        ];
        $specifications[$id] = $specification;
      }
    }
    return $specifications;
  }

  /**
   * Try retrieving an ID from the given class.
   *
   * @param string $class
   *   The fully qualified name of the class.
   *
   * @return string
   *   A string.
   */
  protected function tryGetId(string $class) {
    try {
      return call_user_func([$class, 'getId']);
    }
    catch (\Exception $e) {
      // TODO: Log error.
      return '';
    }
  }

  /**
   * Try retrieving a specification from the given class.
   *
   * @param string $class
   *   The fully qualified name of the class.
   *
   * @return array
   *   An array.
   */
  protected function tryGetSpecification(string $class) {
    try {
      return call_user_func([$class, 'getSpecification']);
    }
    catch (\Exception $e) {
      // TODO: Log error when no specification could be retrieved.
      return [];
    }
  }

}
