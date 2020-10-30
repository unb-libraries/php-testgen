<?php

namespace Tozart\Validation;

use Tozart\Model\ModelFactoryTrait;
use Tozart\Model\ModelInterface;

/**
 * Validator for subject specifications.
 *
 * @package Tozart\Validation
 */
class SubjectValidator extends SpecificationValidator {

  use ModelFactoryTrait;

  /**
   * The model against which the subject is to be verified.
   *
   * @var \Tozart\Model\ModelInterface
   */
  protected $_model;

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
  public function validate($object) {
    if ($valid = parent::validate($object)) {
      $model = $this->getModel();
      $properties = array_merge($model->getRequirements(), $model->getOptions());
      $specification = $this->buildSpecification($object) + $properties;
      foreach (array_intersect_key($specification, $properties) as $property => $value) {
        if ($valid && is_callable($callback = $this->getPropertyCallback($property, $model))) {
          $valid = call_user_func_array($callback, [$value, $property, &$specification]);
        }
      }
    }
    return $valid;
  }

  /**
   * {@inheritDoc}
   */
  protected function defaultSpecification() {
    return [
      'type' => '',
    ];
  }

  /**
   * Callback to validate the "type" property.
   *
   * @param string $type
   *   The type value.
   * @param string $property
   *   The name of the property.
   * @param array $specification
   *   The complete specification.
   *
   * @return bool
   *   TRUE if a model of the given type exists.
   */
  protected function validateType(string $type, string $property, array &$specification) {
    if ($model = $this->modelFactory()->create($type)) {
      $this->setModel($model);
      return TRUE;
    }
    // TODO: Log non-existing model type.
    return FALSE;
  }

}
