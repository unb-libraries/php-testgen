<?php

namespace Tozart\Subject;

/**
 * Interface for subject implementations.
 *
 * @package Tozart\Subject
 */
interface SubjectInterface {

  /**
   * The subject ID.
   *
   * @return string
   *   A string.
   */
  public function getId();

  /**
   * The subject type.
   *
   * @return string
   *   A string.
   */
  public function getType();

  /**
   * The model which the subject is build from.
   *
   * @return \Tozart\Model\ModelInterface
   *   A model instance.
   */
  public function getModel();

  /**
   * Retrieve the given subject property.
   *
   * @param string $property
   *   The property.
   *
   * @return mixed
   *   The property value.
   */
  public function get($property);

  /**
   * An array of property keys and values.
   *
   * @return array
   *   An array of the form PROPERTY => VALUE.
   */
  public function getProperties();

}
