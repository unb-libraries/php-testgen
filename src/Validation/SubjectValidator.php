<?php

namespace Tozart\Validation;

use Tozart\Model\ModelInterface;
use Tozart\Tozart;

/**
 * Validator for subject specifications.
 *
 * @package Tozart\Validation
 */
class SubjectValidator extends SpecificationValidator {

  /**
   * The model factory.
   *
   * @var \Tozart\Discovery\FactoryInterface
   */
  protected $_modelFactory;

  /**
   * The model against which the subject is to be verified.
   *
   * @var \Tozart\Model\ModelInterface
   */
  protected $_model;

  /**
   * Retrieve the model factory.
   *
   * @return \Tozart\Model\ModelFactory
   *   A model factory instance.
   */
  protected function modelFactory() {
    if (!isset($this->_modelFactory)) {
      $this->_modelFactory = Tozart::modelFactory();
    }
    return $this->_modelFactory;
  }

  /**
   * Retrieve the model against which the subject is to be verified.
   *
   * @return \Tozart\Model\ModelInterface
   *   A model instance.
   */
  protected function getModel() {
    return $this->_model;
  }

  /**
   * Assign a model for verification.
   *
   * @param \Tozart\Model\ModelInterface $model
   *   A model instance.
   */
  protected function setModel(ModelInterface $model) {
    $this->_model = $model;
  }

  /**
   * {@inheritDoc}
   */
  protected function essentialProperties(array $specification) {
    return [
      'type'
    ];
  }

  /**
   * {@inheritDoc}
   */
  protected function requiredProperties(array $specification) {
    return $this->getModel()->getRequirements();
  }

  /**
   * {@inheritDoc}
   */
  protected function optionalProperties(array $specification) {
    return array_keys($this->getModel()->getOptions());
  }

  /**
   * Callback to validate the "type" property.
   *
   * @param string $type
   *   A string.
   * @param string $property
   *   A string.
   * @param array $specification
   *   The specification.
   *
   * @return array
   *   An array of error message strings.
   *
   * @see \Tozart\Validation\SpecificationValidator::validateProperty().
   */
  protected function validateType($type, $property, array $specification) {
    $errors = [];
    if ($model = $this->modelFactory()->create($type)) {
      $this->setModel($model);
    }
    else {
      $errors[] = "A model of type \"{$type}\" does not exist.";
    }
    return $errors;
  }

}
