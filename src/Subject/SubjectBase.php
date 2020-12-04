<?php

namespace Tozart\Subject;

use Tozart\Model\ModelInterface;

/**
 * Base class for models.
 *
 * @package Tozart\model
 */
abstract class SubjectBase implements SubjectInterface {

  /**
   * The model definition.
   *
   * @var \Tozart\Model\ModelInterface
   */
  protected $_model;

  /**
   * An array of property keys and values.
   *
   * @var array
   */
  protected $_properties = [];

  /**
   * {@inheritDoc}
   */
  public function getId() {
    return $this->get('id');
  }

  /**
   * {@inheritDoc}
   */
  public function getModel() {
    return $this->_model;
  }

  /**
   * {@inheritDoc}
   */
  public function getType() {
    return $this->getModel()
      ->getType();
  }

  /**
   * Create a new model instance.
   *
   * @param \Tozart\Model\ModelInterface $model
   *   The model definition.
   * @param array $properties
   *   The subject properties.
   */
  final public function __construct(ModelInterface $model, array $properties) {
    $this->_model = $model;
    $this->setProperties($properties);
  }

  /**
   * Assign the given properties.
   *
   * @param array $properties
   *   An array of properties.
   */
  protected function setProperties(array $properties) {
    foreach ($properties as $property => $value) {
      $this->set($property, $value);
    }
  }

  /**
   * Assign the given value to the given property.
   *
   * @param string $property
   *   The property.
   * @param mixed $value
   *   The property value.
   */
  protected function set($property, $value) {
    $specification = array_merge(
      array_keys($this->getModel()->getRequirements()),
      array_keys($this->getModel()->getOptions())
    );
    if (in_array($property, $specification)) {
      $this->_properties[$property] = $value;
    }
  }

  /**
   * {@inheritDoc}
   */
  public function get($property) {
    if (array_key_exists($property, $properties = $this->getProperties())) {
      return $properties[$property];
    }
    return NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function getProperties() {
    return $this->_properties;
  }

  /**
   * {@inheritDoc}
   */
  public function getTemplateDiscoveryPatterns() {
    $id = $this->getId();
    $model_type = $this->getModel()->getType();
    return [
      "/{$id}\.{$model_type}.*/",
      "{$model_type}.*",
    ];
  }

}
