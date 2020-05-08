<?php

namespace Tozart\Subject;

/**
 * Base class for models.
 *
 * @package Tozart\model
 */
abstract class SubjectBase {

  /**
   * The model ID.
   *
   * @var string
   */
  protected $id;

  /**
   * Retrieve the model ID.
   *
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Retrieve the model type.
   *
   * @return string
   */
  abstract public function getType();

  /**
   * The model definition.
   *
   * @var SubjectModel
   */
  protected $definition;

  /**
   * Retrieve the model definition.
   *
   * @return SubjectModel
   *   A model definition.
   */
  public function getDefinition() {
    return $this->definition;
  }

  /**
   * Create a new model instance.
   *
   * @param string $id
   *   The model ID.
   * @param SubjectModel $definition
   *   The model definition.
   * @param array $properties
   *   The model type.
   */
  final public function __construct($id, $definition, array $properties) {
    $this->id = $id;
    $this->definition = $definition;
    foreach ($properties as $property => $value) {
      $this->trySet($property, $value);
    }
  }

  private function trySet($property, $value) {
    try {
      $setter = [$this, $setter_name = 'set' . ucfirst($property)];
      if (is_callable($setter)) {
        $this->$setter_name($value);
      }
      else {
        $this->$property = $value;
      }
    }
    catch (\Exception $e) {
      // TODO: Release a debug or log notice.
    }
  }

  /**
   * Retrieve all property values.
   *
   * @return array
   *   An array of property keys and values.
   */
  public function getProperties() {
    $properties = [];
    foreach ($this->getDefinition()->getProperties() as $property) {
      $properties[$property] = $this->$property;
    }
    return $properties;
  }

}
