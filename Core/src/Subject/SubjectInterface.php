<?php

namespace Trupal\Core\Subject;

/**
 * Interface for subject implementations.
 *
 * @package Trupal\Core\Subject
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
   * @return \Trupal\Core\Model\ModelInterface
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

  // TODO: Determine template discovery patterns in template finder.
  /**
   * Array of search patterns which template file names must match in order to be chosen to render this subject.
   *
   * @return array
   *   An array of regular expressions.
   */
  public function getTemplateDiscoveryPatterns();

}
