<?php

namespace Trupal\Core\Model;

/**
 * Public interface for model implementations.
 *
 * A model specifies which properties
 * each subject must define in order to
 * generate test cases from it.
 *
 * @package Trupal\Core\Model
 */
interface ModelInterface {

  /**
   * Create a new model instance.
   *
   * @param array $specification
   *   The model specification.
   * @return static
   */
  public static function create(array $specification);

  /**
   * Retrieve the model type.
   *
   * @return string
   *   A string.
   */
  public function getType();

  /**
   * Retrieve the fully namespaced model class name.
   *
   * @return string
   *   A string.
   */
  public function getSubjectClass();

  /**
   * Retrieve any required property identifiers.
   *
   * @return array
   *   A one-dimensional array of strings.
   */
  public function getRequirements();

  /**
   * Retrieve any optional property identifiers.
   *
   * @return array
   *   An array of the form PROPERTY_IDENTIFIER => DEFAULT_VALUE.
   */
  public function getOptions();

}
