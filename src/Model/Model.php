<?php

namespace Tozart\Model;

/**
 * Class to represent a model specification.
 *
 * @package Tozart\Model
 */
class Model implements ModelInterface {

  /**
   * The model type.
   *
   * @var string
   */
  protected $type;

  /**
   * The class to use for subjects based on this model.
   *
   * @var string
   */
  protected $subjectClass;

  /**
   * The requirements which a subject based on this model must meet.
   *
   * @var array
   */
  protected $requirements;

  /**
   * The optional properties which a subject based on this model may declare.
   *
   * @var array
   */
  protected $options;

  /**
   * Create a new Model instance.
   *
   * @param array $specification
   *   The model specification.
   */
  public function __construct(array $specification) {
    $this->type = $specification['type'];
    $this->subjectClass = $specification['class'];
    $this->requirements = array_key_exists('requirements', $specification)
      ? $specification['requirements']
      : [];
    $this->options = array_key_exists('options', $specification)
      ? $specification['options']
      : [];
  }

  /**
   * Statically create a new model instance.
   *
   * @param array $specification
   *   The model specification.
   *
   * @return static
   *   A new model instance.
   */
  public static function create(array $specification) {
    return new static($specification);
  }

  /**
   * {@inheritDoc}
   */
  public function getType() {
    return $this->type;
  }

  /**
   * {@inheritDoc}
   */
  public function getSubjectClass() {
    return $this->subjectClass;
  }

  /**
   * {@inheritDoc}
   */
  public function getRequirements() {
    return $this->requirements;
  }

  /**
   * {@inheritDoc}
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * Retrieve the combination of required and optional properties.
   *
   * @return array
   *   An array of properties and values.
   */
  public function getProperties() {
    return array_merge(
        array_values($this->getRequirements()),
        $this->getOptions()
    );
  }

}
