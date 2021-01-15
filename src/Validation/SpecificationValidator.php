<?php

namespace Trupal\Validation;

use Trupal\os\FileInterface;

/**
 * Validator for specification files.
 *
 * @package Trupal\Validation
 */
abstract class SpecificationValidator extends FileFormatValidator {

  /**
   * {@inheritDoc}
   */
  public function validate($object) {
    if ($valid = (parent::validate($object))) {
      $specification = $this->buildSpecification($object);
      foreach ($specification as $property => $value) {
        if ($valid && is_callable($callback = $this->getPropertyCallback($property))) {
          $valid = call_user_func_array($callback, [$value, $property, &$specification]);
        }
      }
    }
    return $valid;
  }

  /**
   * Build the complete specification array.
   *
   * @param \Trupal\os\FileInterface $file
   * @return array|mixed
   */
  protected function buildSpecification(FileInterface $file) {
    return $this->getParser()->parse($file->path())
      + $this->defaultSpecification();
  }

  /**
   * Define the accepted property keys and their default values.
   *
   * @return array
   *   An array of the form PROPERTY => DEFAULT_VALUE.
   */
  protected function defaultSpecification() {
    return [];
  }

  /**
   * Build a property callback for custom validation of the given property.
   *
   * @param string $property
   *   The property Identifier.
   * @param mixed $target
   *   The target class or object for the callback.
   *
   * @return array
   *   A callable array. The method name will be "validateTheProperty"
   *   if the property identifier is "the_property".
   */
  protected function getPropertyCallback(string $property, $target = NULL) {
    $upper_camel_case_property = implode('', array_map(function ($string) {
      return ucfirst($string);
    }, explode('_', $property)));
    $callback_name = 'validate' . $upper_camel_case_property;
    return [$target ?: $this, $callback_name];
  }

}
