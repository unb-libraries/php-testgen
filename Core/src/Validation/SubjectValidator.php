<?php

namespace Trupal\Core\Validation;

use Trupal\Core\Model\ModelFactoryTrait;
use Trupal\Core\Model\ModelInterface;

/**
 * Validator for subject specifications.
 *
 * @package Trupal\Core\Validation
 */
class SubjectValidator extends SpecificationValidator {

  use ModelFactoryTrait;

  /**
   * The model against which the subject is to be verified.
   *
   * @var \Trupal\Core\Model\ModelInterface
   */
  protected $_model;

  /**
   * Retrieve the model against which the subject is to be verified.
   *
   * @return \Trupal\Core\Model\ModelInterface
   *   A model instance.
   */
  protected function getModel() {
    return $this->_model;
  }

  /**
   * Assign a model for verification.
   *
   * @param \Trupal\Core\Model\ModelInterface $model
   *   A model instance.
   */
  protected function setModel(ModelInterface $model) {
    $this->_model = $model;
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'subject';
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
