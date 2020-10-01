<?php

namespace Tozart\Discovery\Filter;

/**
 * Factory to build validators of different types.
 *
 * @package Tozart\Discovery\Filter
 */
class DirectoryFilterFactory implements DirectoryFilterFactoryInterface {

  /**
   * {@inheritDoc}
   */
  public function create(string $type, array $configuration) {
    if ($specification = $this->getSpecification($type)) {
      $class = $specification['class'];
      return call_user_func([$class, 'create'], $configuration);
    }
    throw new \Exception("A filter of type \"{$type}\" could not be created.");
  }

  /**
   * Retrieve the specification for a filter of the given type.
   *
   * @param string $type
   *   A string.
   *
   * @return string|null
   *   An array specifying a filter.
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
    foreach ($this->getFilterClasses() as $class) {
      $interface = $this->getFilterInterface();
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
   * Retrieve an array of filter class names.
   *
   * @return string[]
   *   An array of fully qualified filter class names.
   */
  protected function getFilterClasses() {
    return [
      FileFormatValidationFilter::class,
      FileNamePatternFilter::class,
      FileTypeFilter::class,
      ModelValidationFilter::class,
      SubjectValidationFilter::class,
    ];
  }

  /**
   * Retrieve the interface which filters must implement.
   *
   * @return string
   *   A fully qualified interface name.
   */
  protected function getFilterInterface() {
    return DirectoryFilterInterface::class;
  }

}