<?php

namespace TestGen\model;

/**
 * Base class for models.
 *
 * @package TestGen\model
 */
abstract class Model {

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
   * Create a new model instance.
   *
   * @param string $id
   *   The model ID.
   * @param array $properties
   *   The model type.
   */
  final public function __construct($id, array $properties) {
    $this->id = $id;
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

}
